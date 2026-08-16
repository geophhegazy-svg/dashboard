<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Listeners;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Modules\Notification\Application\Contracts\NotificationServiceInterface;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;

final readonly class SubscriptionRenewedNotificationListener implements EventListenerInterface
{
    public function __construct(
        private NotificationServiceInterface $notificationService,
    ) {}

    public function handle(EventContract $event): void
    {
        if (! $event instanceof SubscriptionRenewed) {
            return;
        }

        $this->notificationService->subscriptionRenewed(
            $event->subscription,
        );
    }
}
