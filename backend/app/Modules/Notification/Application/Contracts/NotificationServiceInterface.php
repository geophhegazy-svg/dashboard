<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Contracts;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

interface NotificationServiceInterface
{
    public function create(array $data): Notification;

    public function createReminder(
        Subscription $subscription,
        int $days,
    ): Notification;

    public function billingFailed(
        Subscription $subscription,
    ): Notification;

    public function subscriptionRenewed(
        Subscription $subscription,
    ): Notification;
}
