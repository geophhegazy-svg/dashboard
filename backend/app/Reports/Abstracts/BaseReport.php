<?php

declare(strict_types=1);

namespace App\Reports\Abstracts;

use App\Reports\Contracts\ReportInterface;
use App\Reports\DTO\ReportResult;
use App\Reports\Filters\ReportFilter;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseReport implements ReportInterface
{
    /**
     * Generate report.
     */
    final public function generate(
        ReportFilter $filter
    ): ReportResult {

        $query = $this->query();

        $this->applyFilters($query, $filter);

        $rows = $this->map(
            $query->get()
        );

        return new ReportResult(
            name: $this->name(),
            title: $this->title(),
            headers: $this->headers(),
            rows: $rows,
            summary: $this->summary($rows),
            meta: [
                'generated_at' => now()->toDateTimeString(),
                'total_rows'   => count($rows),
                'filters'      => $filter->toArray(),
            ],
        );
    }

    /**
     * Base query.
     */
    abstract protected function query(): Builder;

    /**
     * Report headers.
     */
    abstract protected function headers(): array;

    /**
     * Convert models to rows.
     */
    abstract protected function map(
        iterable $records
    ): array;

    /**
     * Apply report filters.
     */
    protected function applyFilters(
        Builder $query,
        ReportFilter $filter
    ): void {

        if ($filter->tenantId !== null) {
            $query->where('tenant_id', $filter->tenantId);
        }

        if ($filter->customerId !== null) {
            $query->where('customer_id', $filter->customerId);
        }

        if ($filter->from !== null) {
            $query->whereDate(
                'created_at',
                '>=',
                $filter->from
            );
        }

        if ($filter->to !== null) {
            $query->whereDate(
                'created_at',
                '<=',
                $filter->to
            );
        }

        if ($filter->sortBy !== null) {
            $query->orderBy(
                $filter->sortBy,
                $filter->sortDirection
            );
        }
    }

    /**
     * Report summary.
     */
    protected function summary(
        array $rows
    ): array {

        return [
            'records' => count($rows),
        ];
    }
}
