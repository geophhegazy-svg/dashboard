<?php

declare(strict_types=1);

namespace App\Modules\Reports\Application\Contracts;

use App\Modules\Reports\Application\DTO\ExportResult;
use App\Modules\Reports\Application\DTO\ReportResult;

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
