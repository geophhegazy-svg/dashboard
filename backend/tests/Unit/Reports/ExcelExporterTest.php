<?php

declare(strict_types=1);

namespace Tests\Unit\Reports;

use App\Reports\DTO\ExportResult;
use App\Reports\DTO\ReportResult;
use App\Reports\Export\ExcelExporter;
use PHPUnit\Framework\TestCase;

class ExcelExporterTest extends TestCase
{
    public function test_excel_exporter_has_correct_name(): void
    {
        $exporter = new ExcelExporter();

        $this->assertEquals(
            'xlsx',
            $exporter->name()
        );
    }

    public function test_excel_export_returns_export_result(): void
    {
        $exporter = new ExcelExporter();

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

        $result = $exporter->export($report);

        $this->assertInstanceOf(
            ExportResult::class,
            $result
        );

        $this->assertEquals(
            'customers.xlsx',
            $result->filename
        );

        $this->assertEquals(
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            $result->mimeType
        );

        $this->assertGreaterThan(
            0,
            $result->size
        );

        $this->assertNotEmpty(
            $result->content
        );
    }
}
