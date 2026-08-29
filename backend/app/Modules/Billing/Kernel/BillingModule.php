<?php

declare(strict_types=1);

namespace App\Modules\Billing\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;

use App\Modules\Billing\Application\Services\BillingCycleService;

use App\Modules\Billing\Domain\Contracts\BillingCycleServiceInterface;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Billing\Policies\InvoicePolicy;

final class BillingModule extends Module
{
    public function name(): string
    {
        return 'Billing';
    }

    public function dependencies(): array
    {
        return [
            \App\Modules\Subscription\Kernel\SubscriptionModule::class,
            \App\Modules\Invoice\Kernel\InvoiceModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                BillingCycleServiceInterface::class
                => BillingCycleService::class,
            ])

            ->policies([

                Invoice::class => InvoicePolicy::class,

            ]);
    }

}
