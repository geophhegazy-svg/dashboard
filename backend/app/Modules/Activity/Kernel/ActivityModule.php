<?php

declare(strict_types=1);

namespace App\Modules\Activity\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;

use App\Modules\Activity\Domain\Contracts\ActivityRepositoryInterface;
use App\Modules\Activity\Infrastructure\Repositories\ActivityRepository;
use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use App\Modules\Activity\Policies\ActivityLogPolicy;

use App\Modules\Activity\Application\Actions\LogActivityAction;

use App\Modules\Activity\Application\Actions\CreateActivityLogAction;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Activity\Application\Listeners\SubscriptionActivatedActivityListener;
use App\Modules\Activity\Application\Listeners\SubscriptionRenewedActivityListener;

final class ActivityModule extends Module
{
    public function name(): string
    {
        return 'Activity';
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

                ActivityRepositoryInterface::class
                    => ActivityRepository::class,



            ])

            ->policies([
                ActivityLog::class => ActivityLogPolicy::class,
            ])

            ->listeners([
                \App\Modules\Subscription\Domain\Events\SubscriptionActivated::class => [
                    SubscriptionActivatedActivityListener::class,
                ],

                SubscriptionRenewed::class => [
                    SubscriptionRenewedActivityListener::class,
                ],
            ])

            ->actions([

                LogActivityAction::class,
                    CreateActivityLogAction::class,

            ]);
    }
}
