<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Notification\NotificationService;
use App\Models\Notification;
use App\Models\Subscription;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_reminder_creates_notification(): void
    {
        $subscription = Subscription::factory()->create();

        $service = new NotificationService();

        $service->createReminder($subscription, 7);

        $this->assertDatabaseHas('notifications', [
            'subscription_id' => $subscription->id,
            'tenant_id'       => $subscription->tenant_id,
            'customer_id'     => $subscription->customer_id,
            'type'            => 'renewal',
            'reminder_day'    => 7,
        ]);

        $this->assertEquals(1, Notification::count());
    }

    public function test_create_reminder_does_not_create_duplicate_notification(): void
    {
        $subscription = Subscription::factory()->create();

        $service = new NotificationService();

        $service->createReminder($subscription, 7);

        $service->createReminder($subscription, 7);

        $this->assertEquals(1, Notification::count());

        $this->assertDatabaseHas('notifications', [
            'subscription_id' => $subscription->id,
            'type' => 'renewal',
            'reminder_day' => 7,
        ]);
    }
}
