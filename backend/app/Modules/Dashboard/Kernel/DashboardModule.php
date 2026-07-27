<?php

declare(strict_types=1);

namespace App\Modules\Dashboard\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Dashboard\Application\Services\CustomerDashboardService;
use App\Modules\Dashboard\Application\Services\DashboardService;

final class DashboardModule extends Module
{
    public function name(): string
    {
        return 'Dashboard';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()
            ->services([
                DashboardService::class => DashboardService::class,
                CustomerDashboardService::class => CustomerDashboardService::class,
            ]);
    }
}
