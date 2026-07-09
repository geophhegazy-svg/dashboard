<?php

declare(strict_types=1);

namespace App\Reports\Export;

use App\Reports\DTO\ExportResult;
use App\Reports\DTO\ReportResult;


class CsvExporter extends AbstractExporter
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

        $content = stream_get_contents($stream);

        fclose($stream);

        return $this->createResult(
            report: $report,
            extension: 'csv',
            mimeType: 'text/csv',
            content: $content,
        );
    }
}
