<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Subscription\Application\Actions\ActivateSubscriptionAction;
use App\Modules\Subscription\Application\Listeners\EnableMikrotikUserListener;
use App\Modules\Subscription\Application\Queries\FindSubscriptionQuery;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
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

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                SubscriptionRepositoryInterface::class =>
                SubscriptionRepository::class,

                SubscriptionRenewalServiceInterface::class =>
                SubscriptionRenewalService::class,

            ])

            ->actions([

                ActivateSubscriptionAction::class,

            ])

            ->queries([

                FindSubscriptionQuery::class =>
                FindSubscriptionQueryHandler::class,

            ])

            ->listeners([

                SubscriptionActivated::class => [
                    EnableMikrotikUserListener::class,
                ],

                SubscriptionRenewed::class => [
                    SubscriptionRenewedListener::class,
                ],

            ]);
    }


}
