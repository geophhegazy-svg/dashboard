<?php

declare(strict_types=1);

namespace Tests\Feature\Reports;

use App\Reports\DTO\ReportResult;
use App\Reports\Export\ExportManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExportServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_manager_is_resolved(): void
    {
        $manager = app(
            ExportManager::class
        );

        $this->assertInstanceOf(
            ExportManager::class,
            $manager
        );
    }

    public function test_csv_exporter_is_registered(): void
    {
        $manager = app(
            ExportManager::class
        );

        $this->assertTrue(
            $manager->has('csv')
        );
    }

    public function test_csv_export_works_without_manual_registration(): void
    {
        $manager = app(
            ExportManager::class
        );

        $report = new ReportResult(
            name: 'customers',
            title: 'Customers',
            headers: ['ID', 'Name'],
            rows: [
                [1, 'Ahmed'],
                [2, 'Mohamed'],
            ],
            summary: [],
            meta: [],
        );

        $csv = $manager->export(
            $report,
            'csv'
        );

        $this->assertStringContainsString(
            'Ahmed',
            $csv
        );

        $this->assertStringContainsString(
            'Mohamed',
            $csv
        );
    }
}
