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
use App\Modules\Subscription\Application\Actions\ChangeSubscriptionStatusAction;
use App\Modules\Subscription\Application\Actions\ExpireSubscriptionAction;
use App\Modules\Subscription\Application\Actions\RenewSubscriptionAction;
use App\Modules\Subscription\Application\Actions\RestoreSubscriptionAction;
use App\Modules\Subscription\Application\Actions\SuspendSubscriptionAction;
use App\Modules\Subscription\Application\Workflows\AutoExpireSubscriptionsWorkflow;
use App\Modules\Subscription\Application\Services\SubscriptionService;


final class SubscriptionModule extends Module
{
    public function name(): string
    {
        return 'Subscription';
    }

    public function dependencies(): array
    {
        return [
            \App\Modules\Network\Kernel\NetworkModule::class,
            \App\Modules\Invoice\Kernel\InvoiceModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                SubscriptionRepositoryInterface::class =>
                SubscriptionRepository::class,

                SubscriptionRenewalServiceInterface::class =>
                SubscriptionRenewalService::class,

                AutoExpireSubscriptionsWorkflow::class =>
                AutoExpireSubscriptionsWorkflow::class,

                SubscriptionService::class
                => SubscriptionService::class,

            ])

            ->actions([

                ActivateSubscriptionAction::class,

                ChangeSubscriptionStatusAction::class,

                ExpireSubscriptionAction::class,

                RenewSubscriptionAction::class,

                RestoreSubscriptionAction::class,

                SuspendSubscriptionAction::class,

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
