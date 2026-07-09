<?php

declare(strict_types=1);

namespace App\Reports\Export\Contracts;

use App\Reports\DTO\ReportResult;

interface Exporter
{
    public function extension(): string;

    public function export(
        ReportResult $report
    ): string;
}
