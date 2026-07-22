<?php

declare(strict_types=1);

namespace App\Modules\Billing\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;

use App\Modules\Billing\Application\Services\AutomaticBillingService;
use App\Modules\Billing\Application\Services\BillingCycleService;
use App\Modules\Billing\Application\Services\InvoiceGenerator;

use App\Modules\Billing\Domain\Contracts\AutomaticBillingServiceInterface;
use App\Modules\Billing\Domain\Contracts\BillingCycleServiceInterface;
use App\Modules\Billing\Domain\Contracts\InvoiceGeneratorInterface;

final class BillingModule extends Module
{
    public function name(): string
    {
        return 'Billing';
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                BillingCycleServiceInterface::class
                => BillingCycleService::class,

                AutomaticBillingServiceInterface::class
                => AutomaticBillingService::class,

                InvoiceGeneratorInterface::class
                => InvoiceGenerator::class,

            ]);
    }
}
