<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Subscription;
use Carbon\Carbon;

class NotificationService
{
    public function createReminder(Subscription $subscription, int $days)
    {
        Notification::firstOrCreate([
            'subscription_id' => $subscription->id,
            'type' => 'renewal',
            'reminder_day' => $days,
        ], [
            'tenant_id' => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'title' => 'Renewal Reminder',
            'message' => "Subscription expires in {$days} day(s).",
            'status' => 'pending',
        ]);
    }
}
