<?php

declare(strict_types=1);

namespace Tests\Unit\Actions;

use App\Modules\Accounting\Domain\Events\JournalEntryPosted;
use App\Modules\Accounting\Infrastructure\Persistence\Models\Account;
use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;
use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntryLine;
use App\Modules\Accounting\Infrastructure\Persistence\Models\AccountingPeriod;
use App\Modules\Accounting\Domain\Enums\AccountingPeriodStatus;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Accounting\Application\Actions\PostJournalEntryAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PostJournalEntryActionTest extends TestCase
{
    use RefreshDatabase;

    private PostJournalEntryAction $action;

    protected function setUp(): void
    {
        parent::setUp();

        $this->action = app(PostJournalEntryAction::class);
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

        $entryDate = now();

        AccountingPeriod::create([
            'tenant_id' => $tenant->id,
            'start_date' => $entryDate->copy()->startOfMonth(),
            'end_date' => $entryDate->copy()->endOfMonth(),
            'status' => AccountingPeriodStatus::OPEN,
        ]);

        $entry = JournalEntry::create([
            'tenant_id' => $tenant->id,
            'entry_number' => 'JV-2026-000001',
            'entry_date' => $entryDate,
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

        $posted = $this->action->execute($entry);

        $this->assertEquals('posted', $posted->status);
        $this->assertNotNull($posted->posted_at);
        $this->assertNotNull($posted->posted_by);

        Event::assertDispatched(JournalEntryPosted::class);
    }

    public function test_entry_cannot_be_posted_without_an_accounting_period(): void
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
            'entry_number' => 'JV-2026-000099',
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

        $this->expectException(
            \App\Exceptions\Accounting\JournalPostingException::class
        );

        $this->action->execute($entry->fresh());
    }

    public function test_entry_cannot_be_posted_in_a_closed_accounting_period(): void
    {
        $entry = $this->createBalancedEntry();

        AccountingPeriod::query()
            ->where('tenant_id', $entry->tenant_id)
            ->update([
                'status' => AccountingPeriodStatus::CLOSED,
            ]);

        $this->expectException(
            \App\Exceptions\Accounting\JournalPostingException::class
        );

        $this->action->execute($entry->fresh());
    }

    public function test_posted_entry_cannot_be_posted_again(): void
    {
        $entry = $this->createBalancedEntry();

        $this->action->execute($entry);

        $this->expectException(\App\Exceptions\Accounting\JournalPostingException::class);

        $this->action->execute($entry->fresh());
    }

    public function test_posting_updates_database(): void
    {
        $entry = $this->createBalancedEntry();

        $this->action->execute($entry);

        $this->assertDatabaseHas('journal_entries', [
            'id' => $entry->id,
            'status' => 'posted',
        ]);
    }

    public function test_posting_sets_posted_at(): void
    {
        $entry = $this->createBalancedEntry();

        $this->action->execute($entry);

        $this->assertNotNull(
            $entry->fresh()->posted_at
        );
    }

    public function test_posting_sets_posted_by(): void
    {
        $entry = $this->createBalancedEntry();

        $this->action->execute($entry);

        $this->assertEquals(
            Auth::id(),
            $entry->fresh()->posted_by
        );
    }
}
