<?php

declare(strict_types=1);

namespace Tests\Unit\Reports;

use App\Reports\DTO\ReportResult;
use App\Reports\Export\CsvExporter;
use App\Reports\Export\ExportManager;
use PHPUnit\Framework\TestCase;

class ExportManagerTest extends TestCase
{
    public function test_csv_exporter_can_be_registered(): void
    {
        $manager = new ExportManager();

        $manager->register(
            new CsvExporter()
        );

        $this->assertTrue(
            $manager->has('csv')
        );

        $this->assertEquals(
            1,
            $manager->count()
        );
    }

    public function test_csv_export_returns_export_result()
    {
        $manager = new ExportManager();

        $manager->register(
            new CsvExporter()
        );

        $report = new ReportResult(
            name: 'customers',
            title: 'Customers',
            headers: [
                'ID',
                'Name',
            ],
            rows: [
                [1, 'Ahmed'],
                [2, 'Mohamed'],
            ],
            summary: [],
            meta: [],
        );

        $result = $manager->export(
            $report,
            'csv'
        );

        $this->assertInstanceOf(
            \App\Reports\DTO\ExportResult::class,
            $result
        );

        $this->assertEquals(
            'customers.csv',
            $result->filename
        );

        $this->assertEquals(
            'text/csv',
            $result->mimeType
        );

        $this->assertGreaterThan(
            0,
            $result->size
        );

        $this->assertStringContainsString(
            'Ahmed',
            $result->content
        );


        $this->assertGreaterThan(
            0,
            $result->size
        );

        $this->assertStringContainsString(
            'Name',
            $result->content
        );
    }

    public function test_unknown_exporter_throws_exception(): void
    {
        $this->expectException(
            \RuntimeException::class
        );

        $manager = new ExportManager();

        $report = new ReportResult(
            name: 'customers',
            title: 'Customers',
            headers: [],
            rows: [],
            summary: [],
            meta: [],
        );

        $manager->export(
            $report,
            'pdf'
        );
    }


}
