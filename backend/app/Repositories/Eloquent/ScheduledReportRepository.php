<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\ScheduledReport;
use Illuminate\Database\Eloquent\Collection;

class ScheduledReportRepository
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
}
