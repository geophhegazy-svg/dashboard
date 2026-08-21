<?php

declare(strict_types=1);

namespace App\Modules\Reports\Application\Actions;

use App\Modules\Reports\Domain\Contracts\ScheduledReportRepositoryInterface;
use App\Modules\Reports\Infrastructure\Persistence\Models\ScheduledReport;

final readonly class UpdateScheduledReportLastRunAction
{
    public function __construct(
        private ScheduledReportRepositoryInterface $repository,
    ) {}

    public function execute(
        ScheduledReport $scheduledReport,
    ): ScheduledReport {
        return $this->repository->update(
            $scheduledReport,
            [
                'last_run_at' => now(),
            ],
        );
    }
}
