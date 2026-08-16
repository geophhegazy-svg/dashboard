<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Services;

use App\Modules\Notification\Application\Contracts\NotificationServiceInterface;
use App\Modules\Notification\Application\Actions\BillingFailedNotificationAction;
use App\Modules\Notification\Application\Actions\CreateNotificationAction;
use App\Modules\Notification\Application\Actions\CreateReminderAction;
use App\Modules\Notification\Application\Actions\SubscriptionRenewedNotificationAction;
use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class NotificationService implements NotificationServiceInterface
{
    public function __construct(
        private readonly CreateNotificationAction $createNotification,
        private readonly CreateReminderAction $createReminder,
        private readonly BillingFailedNotificationAction $billingFailed,
        private readonly SubscriptionRenewedNotificationAction $subscriptionRenewed,
    ) {}

    public function create(
        array $data,
    ): Notification {

        return $this->createNotification->execute(
            new Notification($data),
        );
    }

    public function createReminder(
        Subscription $subscription,
        int $days,
    ): Notification {

        return $this->createReminder->execute(
            $subscription,
            $days,
        );
    }

    public function billingFailed(
        Subscription $subscription,
    ): Notification {

        return $this->billingFailed->execute(
            $subscription,
        );
    }

    public function subscriptionRenewed(
        Subscription $subscription,
    ): Notification {

        return $this->subscriptionRenewed->execute(
            $subscription,
        );
    }
}
