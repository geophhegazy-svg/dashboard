<?php

declare(strict_types=1);

namespace App\Reports\Export\Contracts;

use App\Reports\DTO\ExportResult;
use App\Reports\DTO\ReportResult;

interface ExporterInterface
{
    /**
     * اسم الـ Exporter.
     */
    public function name(): string;

    /**
     * تصدير التقرير.
     */
    public function export(
        ReportResult $report
    ): ExportResult;
}
