<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Kernel;

use App\Core\Kernel\Modules\Module;
use App\Core\EventBus\EventRegistry;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Application\Listeners\EnableMikrotikUserListener;

class SubscriptionModule extends Module
{
    public function name(): string
    {
        return 'Subscription';
    }



    public function register(): void {}



    public function boot(): void
    {
        app(EventRegistry::class)
            ->register(
                SubscriptionActivated::class,
                EnableMikrotikUserListener::class
            );
    }
}
