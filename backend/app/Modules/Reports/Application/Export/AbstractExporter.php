<?php

declare(strict_types=1);

namespace App\Modules\Reports\Application\Export;

use App\Modules\Reports\Application\DTO\ExportResult;
use App\Modules\Reports\Application\DTO\ReportResult;
use App\Modules\Reports\Application\Contracts\ExporterInterface;

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
