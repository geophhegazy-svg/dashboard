<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\Accounting\JournalValidationException;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\Tenant;
use App\Modules\Accounting\Application\Services\JournalValidationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JournalValidationServiceTest extends TestCase
{
    use RefreshDatabase;

    private JournalValidationService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new JournalValidationService();
    }

    public function test_balanced_entry_passes_validation(): void
    {
        $tenant = Tenant::factory()->create();

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

        $this->service->validate($entry);

        $this->assertTrue(true);
    }

    public function test_unbalanced_entry_throws_exception(): void
    {
        $tenant = Tenant::factory()->create();

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
            'credit' => 50,
        ]);

        $this->expectException(JournalValidationException::class);

        $this->service->validate($entry);
    }

    public function test_entry_without_lines_throws_exception(): void
    {
        $tenant = Tenant::factory()->create();

        $entry = JournalEntry::create([
            'tenant_id' => $tenant->id,
            'entry_number' => 'JV-2026-000001',
            'entry_date' => now(),
            'status' => 'draft',
        ]);

        $this->expectException(JournalValidationException::class);

        $this->service->validate($entry);
    }


    public function test_line_with_negative_amount_throws_exception(): void
    {
        $tenant = Tenant::factory()->create();

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
        ]);

        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $account1->id,
            'debit' => -100,
            'credit' => 0,
        ]);

        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $account2->id,
            'debit' => 0,
            'credit' => 100,
        ]);

        $this->expectException(JournalValidationException::class);

        $this->service->validate($entry);
    }

    public function test_line_with_both_debit_and_credit_throws_exception(): void
    {
        $tenant = Tenant::factory()->create();

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
        ]);

        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $account1->id,
            'debit' => 100,
            'credit' => 100,
        ]);

        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $account2->id,
            'debit' => 0,
            'credit' => 100,
        ]);

        $this->expectException(JournalValidationException::class);

        $this->service->validate($entry);
    }

    public function test_line_without_amount_throws_exception(): void
    {
        $tenant = Tenant::factory()->create();

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
        ]);

        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $account1->id,
            'debit' => 0,
            'credit' => 0,
        ]);

        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $account2->id,
            'debit' => 0,
            'credit' => 100,
        ]);

        $this->expectException(JournalValidationException::class);

        $this->service->validate($entry);
    }
}
