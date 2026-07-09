<?php

declare(strict_types=1);

namespace Tests\Unit\Reports;

use App\Reports\Export\Contracts\ExporterInterface;
use App\Reports\Export\CsvExporter;
use PHPUnit\Framework\TestCase;

class ExporterContractTest extends TestCase
{
    public function test_csv_exporter_implements_contract(): void
    {
        $exporter = new CsvExporter();

        $this->assertInstanceOf(
            ExporterInterface::class,
            $exporter
        );
    }

    public function test_csv_exporter_has_correct_name(): void
    {
        $exporter = new CsvExporter();

        $this->assertEquals(
            'csv',
            $exporter->name()
        );
    }
}
