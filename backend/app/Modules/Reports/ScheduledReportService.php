<?php

declare(strict_types=1);

namespace App\Modules\Reports;

use App\Models\ScheduledReport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ScheduledReportService
{
    public function paginate(): LengthAwarePaginator
    {
        return ScheduledReport::latest()->paginate();
    }

    public function create(array $data): ScheduledReport
    {
        return ScheduledReport::create($data);
    }

    public function update(
        ScheduledReport $scheduledReport,
        array $data
    ): ScheduledReport {

        $scheduledReport->update($data);

        return $scheduledReport->fresh();
    }

    public function delete(
        ScheduledReport $scheduledReport
    ): void {

        $scheduledReport->delete();
    }

    public function activate(
        ScheduledReport $scheduledReport
    ): ScheduledReport {

        $scheduledReport->update([
            'is_active' => true,
        ]);

        return $scheduledReport->fresh();
    }

    public function deactivate(
        ScheduledReport $scheduledReport
    ): ScheduledReport {

        $scheduledReport->update([
            'is_active' => false,
        ]);

        return $scheduledReport->fresh();
    }

    public function updateLastRun(
        ScheduledReport $scheduledReport
    ): ScheduledReport {

        $scheduledReport->update([
            'last_run_at' => now(),
        ]);

        return $scheduledReport->fresh();
    }

    public function updateNextRun(
        ScheduledReport $scheduledReport,
        \DateTimeInterface $nextRun
    ): ScheduledReport {

        $scheduledReport->update([
            'next_run_at' => $nextRun,
        ]);

        return $scheduledReport->fresh();
    }
}
