<?php

declare(strict_types=1);

namespace App\Reports\Export;

use App\Reports\DTO\ExportResult;
use App\Reports\DTO\ReportResult;
use App\Reports\Export\Contracts\ExporterInterface;

class CsvExporter implements ExporterInterface
{
    public function name(): string
    {
        return 'csv';
    }

    public function export(
        ReportResult $report
    ): ExportResult {

        $stream = fopen('php://temp', 'r+');

        fputcsv($stream, $report->headers, ',', '"', '');

        foreach ($report->rows as $row) {
            fputcsv($stream, $row, ',', '"', '');
        }

        rewind($stream);

        $csv = stream_get_contents($stream);

        fclose($stream);

        return new ExportResult(
            filename: $report->name . '.csv',
            mimeType: 'text/csv',
            content: $csv ?: '',
            size: strlen($csv ?: ''),
        );
    }
}
