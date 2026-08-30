<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Subscription\Presentation\Console\Commands\AutoGraceSubscriptionsCommand;
use App\Modules\Subscription\Presentation\Console\Commands\AutoRenewSubscriptionsCommand;
use App\Modules\Subscription\Presentation\Console\Commands\AutoExpireSubscriptionsCommand;
use App\Modules\Subscription\Application\Actions\ActivateSubscriptionAction;
use App\Modules\Subscription\Application\Actions\CreateHotspotSubscriptionAction;
use App\Modules\Subscription\Application\Actions\ActivateHotspotSubscriptionAction;
use App\Modules\Subscription\Application\Actions\SuspendHotspotSubscriptionAction;
use App\Modules\Subscription\Application\Actions\DeleteHotspotSubscriptionAction;
use App\Modules\Subscription\Policies\HotspotSubscriptionPolicy;
use App\Modules\Subscription\Application\Queries\FindSubscriptionQuery;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Application\Queries\Handlers\FindSubscriptionQueryHandler;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Domain\Contracts\HotspotSubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Repositories\SubscriptionRepository;
use App\Modules\Subscription\Infrastructure\Repositories\HotspotSubscriptionRepository;

use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Subscription\Domain\Events\SubscriptionRestored;
use App\Modules\Subscription\Application\Listeners\SubscriptionRenewedListener;

use App\Modules\Subscription\Application\Actions\EnterGraceSubscriptionAction;
use App\Modules\Subscription\Application\Actions\ExpireSubscriptionAction;
use App\Modules\Subscription\Application\Actions\RenewSubscriptionAction;
use App\Modules\Subscription\Application\Actions\RestoreSubscriptionAction;
use App\Modules\Subscription\Application\Actions\SuspendSubscriptionAction;
use App\Modules\Subscription\Application\Orchestrators\AutoExpireSubscriptionsOrchestrator;
use App\Modules\Subscription\Application\Orchestrators\AutoExpireSubscriptionsOrchestratorInterface;
use App\Modules\Subscription\Application\Orchestrators\AutoGraceSubscriptionsOrchestrator;
use App\Modules\Subscription\Application\Orchestrators\AutoRenewSubscriptionsOrchestrator;
use App\Modules\Subscription\Application\Orchestrators\AutoGraceSubscriptionsOrchestratorInterface;
use App\Modules\Subscription\Application\Orchestrators\AutoRenewSubscriptionsOrchestratorInterface;


final class SubscriptionModule extends Module
{
    public function name(): string
    {
        return 'Subscription';
    }

    public function dependencies(): array
    {
        return [
            \App\Modules\Invoice\Kernel\InvoiceModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                SubscriptionRepositoryInterface::class =>
                SubscriptionRepository::class,

                HotspotSubscriptionRepositoryInterface::class =>
                HotspotSubscriptionRepository::class,

                AutoExpireSubscriptionsOrchestratorInterface::class =>
                AutoExpireSubscriptionsOrchestrator::class,

                AutoGraceSubscriptionsOrchestratorInterface::class =>
                AutoGraceSubscriptionsOrchestrator::class,

                AutoRenewSubscriptionsOrchestratorInterface::class =>
                AutoRenewSubscriptionsOrchestrator::class,

            ])

            ->commands([
                AutoGraceSubscriptionsCommand::class,
                AutoExpireSubscriptionsCommand::class,
                AutoRenewSubscriptionsCommand::class,
            ])

            ->policies([
                \App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription::class =>
                HotspotSubscriptionPolicy::class,
            ])

            ->actions([

                ActivateSubscriptionAction::class,

                CreateHotspotSubscriptionAction::class,
                ActivateHotspotSubscriptionAction::class,
                SuspendHotspotSubscriptionAction::class,
                DeleteHotspotSubscriptionAction::class,

                
                EnterGraceSubscriptionAction::class,

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

                SubscriptionRenewed::class => [
                    SubscriptionRenewedListener::class,
                ],

            ]);
    }


}
