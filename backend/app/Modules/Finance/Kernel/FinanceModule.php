<?php

declare(strict_types=1);

namespace App\Modules\Finance\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Finance\Application\Services\FinanceService;
use App\Modules\Finance\Domain\Contracts\FinanceServiceInterface;

final class FinanceModule extends Module
{
    public function name(): string
    {
        return 'Finance';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->singletons([

                FinanceServiceInterface::class
                => FinanceService::class,

            ]);
    }
}
