<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Actions;

use App\Modules\Notification\Infrastructure\Persistence\Models\Notification;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class BillingFailedNotificationAction
{
    public function __construct(
        private CreateNotificationAction $create,
    ) {}

    public function execute(
        Subscription $subscription,
    ): Notification {

        return $this->create->execute(

            new Notification([

                'tenant_id'   => $subscription->tenant_id,

                'customer_id' => $subscription->customer_id,

                'type'        => 'billing_failed',

                'title'       => 'فشل التجديد التلقائي',

                'message'     => 'تعذر تنفيذ التجديد التلقائي لاشتراكك.',

                'sent_at'     => now(),

            ])
        );
    }
}
