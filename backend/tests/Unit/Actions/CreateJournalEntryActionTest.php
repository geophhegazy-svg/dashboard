<?php

declare(strict_types=1);

namespace Tests\Unit\Actions;

use App\Modules\Accounting\Application\Actions\CreateJournalEntryAction;
use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;
use App\Modules\Accounting\Kernel\AccountingModule;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreateJournalEntryActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_first_entry_gets_first_number_and_draft_status(): void
    {
        $tenant = Tenant::factory()->create();

        $entry = app(CreateJournalEntryAction::class)->execute([
            'tenant_id' => $tenant->id,
            'entry_date' => '2026-09-06',
            'description' => 'Opening journal entry',
        ]);

        $this->assertInstanceOf(JournalEntry::class, $entry);
        $this->assertSame('JV-2026-000001', $entry->entry_number);
        $this->assertSame('draft', $entry->status);
        $this->assertNull($entry->posted_at);
        $this->assertNull($entry->posted_by);
        $this->assertDatabaseHas('journal_entries', [
            'id' => $entry->id,
            'tenant_id' => $tenant->id,
            'entry_number' => 'JV-2026-000001',
            'status' => 'draft',
        ]);
    }

    public function test_numbering_increments_for_same_tenant_and_year(): void
    {
        $tenant = Tenant::factory()->create();

        $action = app(CreateJournalEntryAction::class);

        $first = $action->execute([
            'tenant_id' => $tenant->id,
            'entry_date' => '2026-09-06',
        ]);

        $second = $action->execute([
            'tenant_id' => $tenant->id,
            'entry_date' => '2026-12-31',
        ]);

        $this->assertSame('JV-2026-000001', $first->entry_number);
        $this->assertSame('JV-2026-000002', $second->entry_number);
    }

    public function test_numbering_is_isolated_per_tenant(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $action = app(CreateJournalEntryAction::class);

        $firstA = $action->execute([
            'tenant_id' => $tenantA->id,
            'entry_date' => '2026-09-06',
        ]);

        $secondA = $action->execute([
            'tenant_id' => $tenantA->id,
            'entry_date' => '2026-09-06',
        ]);

        $firstB = $action->execute([
            'tenant_id' => $tenantB->id,
            'entry_date' => '2026-09-06',
        ]);

        $this->assertSame('JV-2026-000001', $firstA->entry_number);
        $this->assertSame('JV-2026-000002', $secondA->entry_number);
        $this->assertSame('JV-2026-000001', $firstB->entry_number);
    }

    public function test_numbering_resets_for_new_year(): void
    {
        $tenant = Tenant::factory()->create();

        $action = app(CreateJournalEntryAction::class);

        $entry2026 = $action->execute([
            'tenant_id' => $tenant->id,
            'entry_date' => '2026-12-31',
        ]);

        $entry2027 = $action->execute([
            'tenant_id' => $tenant->id,
            'entry_date' => '2027-01-01',
        ]);

        $this->assertSame('JV-2026-000001', $entry2026->entry_number);
        $this->assertSame('JV-2027-000001', $entry2027->entry_number);
    }

    public function test_creation_forces_draft_state(): void
    {
        $tenant = Tenant::factory()->create();

        $entry = app(CreateJournalEntryAction::class)->execute([
            'tenant_id' => $tenant->id,
            'entry_date' => '2026-09-06',
            'status' => 'posted',
            'posted_at' => now(),
            'posted_by' => 999999,
        ]);

        $this->assertSame('draft', $entry->status);
        $this->assertNull($entry->posted_at);
        $this->assertNull($entry->posted_by);
    }
}
