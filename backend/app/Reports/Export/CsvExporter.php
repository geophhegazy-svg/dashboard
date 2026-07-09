<?php

declare(strict_types=1);

namespace App\Reports\Export;

use App\Reports\DTO\ReportResult;
use App\Reports\Export\Contracts\Exporter;

class CsvExporter implements Exporter
{
    public function extension(): string
    {
        return 'csv';
    }

    public function export(
        ReportResult $report
    ): string {

        $stream = fopen(
            'php://temp',
            'r+'
        );

        fputcsv(
            $stream,
            $report->headers,
            ',',
            '"',
            '\\'
        );

        foreach ($report->rows as $row) {
            fputcsv(
                $stream,
                $row,
                ',',
                '"',
                '\\'
            );
        }

        rewind($stream);

        $csv = stream_get_contents(
            $stream
        );

        fclose($stream);

        return $csv ?: '';
    }
}
