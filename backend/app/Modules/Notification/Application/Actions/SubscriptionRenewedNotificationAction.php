<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Actions;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Notification\Domain\Contracts\NotificationRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class SubscriptionRenewedNotificationAction
{
    public function __construct(
        private NotificationRepositoryInterface $repository,
    ) {}

    public function execute(
        Subscription $subscription,
    ): Notification {

        return $this->repository->firstOrCreate(

            [

                'tenant_id' => $subscription->tenant_id,

                'customer_id' => $subscription->customer_id,

                'type' => 'subscription_renewed',

            ],

            [

                'title' => 'تم تجديد الاشتراك',

                'message' => 'تم تجديد اشتراكك بنجاح.',

                'sent_at' => now(),

            ]

        );
    }
}
