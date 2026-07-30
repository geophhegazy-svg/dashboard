<?php

declare(strict_types=1);

namespace App\Modules\Reports\Infrastructure\Repositories;

use App\Models\ScheduledReport;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Reports\Domain\Contracts\ScheduledReportRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
final class ScheduledReportRepository implements ScheduledReportRepositoryInterface
{
    public function all(): Collection
    {
        return ScheduledReport::query()
            ->latest()
            ->get();
    }

    public function find(
        int $id
    ): ?ScheduledReport {

        return ScheduledReport::query()->find($id);
    }

    public function create(
        array $data
    ): ScheduledReport {

        return ScheduledReport::query()->create($data);
    }

    public function update(
        ScheduledReport $scheduledReport,
        array $data
    ): ScheduledReport {

        $scheduledReport->update($data);

        return $scheduledReport->refresh();
    }

    public function delete(
        ScheduledReport $scheduledReport
    ): bool {

        return (bool) $scheduledReport->delete();
    }

    public function paginate(): LengthAwarePaginator
    {
        return ScheduledReport::query()
            ->latest()
            ->paginate();
    }
}
