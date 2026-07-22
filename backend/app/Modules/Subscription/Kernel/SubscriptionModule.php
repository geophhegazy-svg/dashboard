<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Core\Kernel\Resources\ActionResource;
use App\Core\Kernel\Resources\EventListenerResource;
use App\Core\Kernel\Resources\QueryResource;
use App\Modules\Subscription\Application\Actions\ActivateSubscriptionAction;
use App\Modules\Subscription\Application\Listeners\EnableMikrotikUserListener;
use App\Modules\Subscription\Application\Queries\FindSubscriptionQuery;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Core\Kernel\Resources\ListenerResource;
use App\Core\Kernel\Resources\ServiceResource;
use App\Modules\Subscription\Application\Queries\Handlers\FindSubscriptionQueryHandler;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Repositories\SubscriptionRepository;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRenewalServiceInterface;
use App\Modules\Subscription\Domain\Services\SubscriptionRenewalService;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Subscription\Application\Listeners\SubscriptionRenewedListener;

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
            new ServiceResource([

                SubscriptionRepositoryInterface::class =>
                SubscriptionRepository::class,

                SubscriptionRenewalServiceInterface::class =>
                SubscriptionRenewalService::class,

            ])
            )

            ->add(
                new ActionResource([
                    ActivateSubscriptionAction::class,
                ])
            )

            ->add(
            new QueryResource([
                FindSubscriptionQuery::class =>
                FindSubscriptionQueryHandler::class,
                ])
            )

            ->add(
            new ListenerResource([

                SubscriptionActivated::class => [
                    EnableMikrotikUserListener::class,
                ],

                SubscriptionRenewed::class => [
                    SubscriptionRenewedListener::class,
                ],

            ])
        );
    }
}
