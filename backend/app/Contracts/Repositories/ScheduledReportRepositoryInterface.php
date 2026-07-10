<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\ScheduledReport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ScheduledReportRepositoryInterface
{
    public function paginate(): LengthAwarePaginator;

    public function create(array $data): ScheduledReport;

    public function update(
        ScheduledReport $report,
        array $data
    ): ScheduledReport;

    public function delete(
        ScheduledReport $report
    ): bool;

    public function find(
        int $id
    ): ?ScheduledReport;
}
