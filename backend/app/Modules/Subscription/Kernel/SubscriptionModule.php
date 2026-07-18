<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Core\Kernel\Resources\ActionResource;
use App\Core\Kernel\Resources\EventListenerResource;
use App\Modules\Subscription\Application\Commands\ActivateSubscriptionAction;
use App\Modules\Subscription\Application\Listeners\EnableMikrotikUserListener;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Core\Kernel\Resources\ListenerResource;
final class SubscriptionModule extends Module
{
    public function name(): string
    {
        return 'Subscription';
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()
            ->add(
                new ActionResource([
                    ActivateSubscriptionAction::class,
                ])
            )
            ->add(
                new ListenerResource([
                    SubscriptionActivated::class => [
                        EnableMikrotikUserListener::class,
                    ],
                ])
            );
    }
}
