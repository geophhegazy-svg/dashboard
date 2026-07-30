<?php

declare(strict_types=1);

namespace App\Modules\Reports\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;

use App\Modules\Reports\Domain\Contracts\ReportExportRepositoryInterface;
use App\Modules\Reports\Domain\Contracts\ReportRepositoryInterface;
use App\Modules\Reports\Domain\Contracts\ScheduledReportRepositoryInterface;

use App\Modules\Reports\Infrastructure\Repositories\ReportExportRepository;
use App\Modules\Reports\Infrastructure\Repositories\ReportRepository;
use App\Modules\Reports\Infrastructure\Repositories\ScheduledReportRepository;

final class ReportsModule extends Module
{
    public function name(): string
    {
        return 'Reports';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()
            ->services([

                ReportRepositoryInterface::class
                    => ReportRepository::class,

                ReportExportRepositoryInterface::class
                    => ReportExportRepository::class,

                ScheduledReportRepositoryInterface::class
                    => ScheduledReportRepository::class,

            ]);
    }
}
