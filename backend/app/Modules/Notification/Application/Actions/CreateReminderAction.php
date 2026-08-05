<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Actions;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Notification\Domain\Contracts\NotificationRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class CreateReminderAction
{
    public function __construct(
        private NotificationRepositoryInterface $repository,
    ) {}

    public function execute(
        Subscription $subscription,
        int $days,
    ): Notification {

        return $this->repository->firstOrCreate(

            [

                'subscription_id' => $subscription->id,

                'type' => 'renewal',

                'reminder_day' => $days,

            ],

            [

                'tenant_id' => $subscription->tenant_id,

                'customer_id' => $subscription->customer_id,

                'title' => 'Renewal Reminder',

                'message' => "Your subscription will expire in {$days} day(s).",

                'sent_at' => now(),

            ]

        );
    }
}
