<?php

declare(strict_types=1);

namespace App\Reports\Contracts;

use App\Reports\DTO\ReportResult;
use App\Reports\Filters\ReportFilter;

interface ReportInterface
{
    /**
     * Report unique name.
     */
    public function name(): string;

    /**
     * Human readable title.
     */
    public function title(): string;

    /**
     * Generate report.
     */
    public function generate(
        ReportFilter $filter
    ): ReportResult;
}
