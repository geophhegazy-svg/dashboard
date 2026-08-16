<?php

declare(strict_types=1);

namespace App\Modules\Notification\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Notification\Application\Contracts\NotificationServiceInterface;
use App\Modules\Notification\Application\Services\NotificationService;
use App\Modules\Notification\Application\Actions\BillingFailedNotificationAction;
use App\Modules\Notification\Application\Actions\CreateNotificationAction;
use App\Modules\Notification\Application\Actions\CreateReminderAction;
use App\Modules\Notification\Application\Actions\SubscriptionRenewedNotificationAction;
use App\Modules\Notification\Application\Listeners\SubscriptionRenewedNotificationListener;
use App\Modules\Notification\Domain\Contracts\NotificationRepositoryInterface;
use App\Modules\Notification\Infrastructure\Repositories\NotificationRepository;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;

final class NotificationModule extends Module
{
    public function name(): string
    {
        return 'Notification';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                NotificationRepositoryInterface::class
                    => NotificationRepository::class,

                NotificationServiceInterface::class
                    => NotificationService::class,

            ])

            ->listeners([

                SubscriptionRenewed::class => [
                    SubscriptionRenewedNotificationListener::class,
                ],

            ])

            ->actions([

                BillingFailedNotificationAction::class,
                CreateNotificationAction::class,
                CreateReminderAction::class,
                SubscriptionRenewedNotificationAction::class,

            ]);
    }
}
