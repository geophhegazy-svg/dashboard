<?php

declare(strict_types=1);

namespace App\Modules\Reports\Application\Manager;

use App\Modules\Reports\Application\DTO\ReportResult;
use App\Modules\Reports\Application\Filters\ReportFilter;
use App\Modules\Reports\Application\Registry\ReportRegistry;

class ReportManager
{
    public function __construct(
        private readonly ReportRegistry $registry,
    ) {}

    /**
     * Execute a report by name.
     */
    public function run(
        string $name,
        ReportFilter $filter,
    ): ReportResult {

        return $this->registry
            ->get($name)
            ->generate($filter);
    }

    /**
     * Return all available reports.
     */
    public function availableReports(): array
    {
        return $this->registry->list();
    }

    /**
     * Check if report exists.
     */
    public function has(
        string $name,
    ): bool {

        return $this->registry->has($name);
    }

    /**
     * Register a report.
     */
    public function register(
        \App\Modules\Reports\Application\Contracts\ReportInterface $report,
    ): self {

        $this->registry->register($report);

        return $this;
    }

    /**
     * Number of registered reports.
     */
    public function count(): int
    {
        return $this->registry->count();
    }
}
