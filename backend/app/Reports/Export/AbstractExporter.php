<?php

declare(strict_types=1);

namespace App\Reports\Export;

use App\Reports\DTO\ExportResult;
use App\Reports\DTO\ReportResult;
use App\Reports\Export\Contracts\ExporterInterface;

abstract class AbstractExporter implements ExporterInterface
{
    protected function createResult(
        ReportResult $report,
        string $extension,
        string $mimeType,
        string $content
    ): ExportResult {
        return new ExportResult(
            filename: "{$report->name}.{$extension}",
            mimeType: $mimeType,
            content: $content,
            size: strlen($content),
        );
    }
}
