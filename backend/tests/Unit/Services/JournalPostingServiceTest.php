<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Events\JournalEntryPosted;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\Tenant;
use App\Models\User;
use App\Modules\Accounting\Application\Services\JournalPostingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class JournalPostingServiceTest extends TestCase
{
    use RefreshDatabase;

    private JournalPostingService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(JournalPostingService::class);
    }

    private function createBalancedEntry(): JournalEntry
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->actingAs($user);

        $account1 = Account::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $account2 = Account::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $entry = JournalEntry::create([
            'tenant_id' => $tenant->id,
            'entry_number' => 'JV-2026-000001',
            'entry_date' => now(),
            'status' => 'draft',
            'created_by' => $user->id,
        ]);

        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $account1->id,
            'debit' => 100,
            'credit' => 0,
        ]);

        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $account2->id,
            'debit' => 0,
            'credit' => 100,
        ]);

        return $entry->fresh();
    }

    public function test_draft_entry_can_be_posted(): void
    {
        Event::fake();

        $entry = $this->createBalancedEntry();

        $posted = $this->service->post($entry);

        $this->assertEquals('posted', $posted->status);
        $this->assertNotNull($posted->posted_at);
        $this->assertNotNull($posted->posted_by);

        Event::assertDispatched(JournalEntryPosted::class);
    }

    public function test_posted_entry_cannot_be_posted_again(): void
    {
        $entry = $this->createBalancedEntry();

        $this->service->post($entry);

        $this->expectException(\App\Exceptions\Accounting\JournalPostingException::class);

        $this->service->post($entry->fresh());
    }

    public function test_posting_updates_database(): void
    {
        $entry = $this->createBalancedEntry();

        $this->service->post($entry);

        $this->assertDatabaseHas('journal_entries', [
            'id' => $entry->id,
            'status' => 'posted',
        ]);
    }

    public function test_posting_sets_posted_at(): void
    {
        $entry = $this->createBalancedEntry();

        $this->service->post($entry);

        $this->assertNotNull(
            $entry->fresh()->posted_at
        );
    }

    public function test_posting_sets_posted_by(): void
    {
        $entry = $this->createBalancedEntry();

        $this->service->post($entry);

        $this->assertEquals(
            Auth::id(),
            $entry->fresh()->posted_by
        );
    }
}
