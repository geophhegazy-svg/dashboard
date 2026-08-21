<?php

declare(strict_types=1);

namespace App\Modules\Reports\Application\Contracts;

use App\Modules\Reports\Application\DTO\ReportResult;
use App\Modules\Reports\Application\Filters\ReportFilter;

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
