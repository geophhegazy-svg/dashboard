<?php

declare(strict_types=1);

namespace App\Modules\Network\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Network\Application\MikrotikServiceAdapter;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Application\Listeners\SubscriptionNetworkLifecycleListener;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Domain\Events\SubscriptionExpired;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Subscription\Domain\Events\SubscriptionRestored;
use App\Modules\Subscription\Domain\Events\SubscriptionSuspended;

final class NetworkModule extends Module
{
    public function name(): string
    {
        return 'Network';
    }

    public function dependencies(): array
    {
        return [
            \App\Modules\Subscription\Kernel\SubscriptionModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                MikrotikServiceInterface::class
                => MikrotikServiceAdapter::class,

            ])

            ->listeners([

                SubscriptionActivated::class => [
                    SubscriptionNetworkLifecycleListener::class,
                ],

                SubscriptionSuspended::class => [
                    SubscriptionNetworkLifecycleListener::class,
                ],

                SubscriptionExpired::class => [
                    SubscriptionNetworkLifecycleListener::class,
                ],

                SubscriptionRestored::class => [
                    SubscriptionNetworkLifecycleListener::class,
                ],

                SubscriptionRenewed::class => [
                    SubscriptionNetworkLifecycleListener::class,
                ],

            ]);
    }
}
