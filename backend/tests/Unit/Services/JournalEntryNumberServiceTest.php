<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\JournalEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Finance\JournalEntryNumberService;

class JournalEntryNumberServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_first_number_is_generated(): void
    {
        $number = app(JournalEntryNumberService::class)->generate();

        $this->assertMatchesRegularExpression(
            '/JV-\d{4}-000001/',
            $number
        );
    }

    public function test_next_number_is_generated(): void
    {
        $tenant = \App\Models\Tenant::factory()->create();

        JournalEntry::create([
            'tenant_id'    => $tenant->id,
            'entry_number' => 'JV-' . now()->year . '-000001',
            'entry_date'   => now(),
            'status'       => 'draft',
        ]);

        $number = app(JournalEntryNumberService::class)->generate();

        $this->assertStringEndsWith(
            '000002',
            $number
        );
    }
}
