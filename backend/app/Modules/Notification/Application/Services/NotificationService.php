<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Services;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Notification\Application\Workflows\BillingFailedNotificationWorkflow;
use App\Modules\Notification\Application\Workflows\CreateNotificationWorkflow;
use App\Modules\Notification\Application\Workflows\CreateReminderWorkflow;
use App\Modules\Notification\Application\Workflows\SubscriptionRenewedNotificationWorkflow;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class NotificationService
{
    public function __construct(
        private readonly CreateNotificationWorkflow $createNotification,
        private readonly CreateReminderWorkflow $createReminder,
        private readonly BillingFailedNotificationWorkflow $billingFailed,
        private readonly SubscriptionRenewedNotificationWorkflow $subscriptionRenewed,
    ) {}

    public function create(
        array $data,
    ): Notification {

        return $this->createNotification->execute(
            $data,
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
