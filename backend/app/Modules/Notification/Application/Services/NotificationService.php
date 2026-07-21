<?php

declare(strict_types=1);

namespace App\Modules\Notification\Application\Services;

use App\Models\Notification;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class NotificationService
{
    /**
     * Create generic notification.
     */
    public function create(array $data): Notification
    {
        return Notification::create($data);
    }

    /**
     * Create renewal reminder.
     */
    public function createReminder(
        Subscription $subscription,
        int $days
    ): Notification {

        return Notification::firstOrCreate(

            [
                'subscription_id' => $subscription->id,
                'type'            => 'renewal',
                'reminder_day'    => $days,
            ],

            [
                'tenant_id'   => $subscription->tenant_id,
                'customer_id' => $subscription->customer_id,
                'title'       => 'Renewal Reminder',
                'message'     => "Your subscription will expire in {$days} day(s).",
                'sent_at'     => now(),
            ]
        );
    }

    /**
     * Billing failed notification.
     */
    public function billingFailed(
        Subscription $subscription
    ): Notification {

        return $this->create([
            'tenant_id'   => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'type'        => 'billing_failed',
            'title'       => 'فشل التجديد التلقائي',
            'message'     => 'تعذر تنفيذ التجديد التلقائي لاشتراكك.',
            'sent_at'     => now(),
        ]);
    }

    /**
     * Subscription renewed notification.
     */
    public function subscriptionRenewed(
        Subscription $subscription
    ): Notification {

        return Notification::firstOrCreate(

            [
                'tenant_id'   => $subscription->tenant_id,
                'customer_id' => $subscription->customer_id,
                'type'        => 'subscription_renewed',
            ],

            [
                'title'   => 'تم تجديد الاشتراك',
                'message' => 'تم تجديد اشتراكك بنجاح.',
                'sent_at' => now(),
            ]
        );
    }
}
