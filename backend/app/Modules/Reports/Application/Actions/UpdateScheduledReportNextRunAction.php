<?php

declare(strict_types=1);

namespace App\Modules\Reports\Application\Actions;

use App\Modules\Reports\Domain\Contracts\ScheduledReportRepositoryInterface;
use App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport;
use DateTimeInterface;

final readonly class UpdateScheduledReportNextRunAction
{
    public function __construct(
        private ScheduledReportRepositoryInterface $repository,
    ) {}

    public function execute(
        ScheduledReport $scheduledReport,
        DateTimeInterface $nextRun,
    ): ScheduledReport {
        return $this->repository->update(
            $scheduledReport,
            [
                'next_run_at' => $nextRun,
            ],
        );
    }
}
