<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Activity\Listeners;

use App\Modules\Activity\Application\Listeners\SubscriptionActivatedActivityListener;
use App\Modules\Activity\Infrastructure\Persistence\Models\ActivityLog;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Domain\Events\SubscriptionRestored;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SubscriptionActivatedActivityListenerTest extends TestCase
{
    use RefreshDatabase;

    public function test_listener_logs_subscription_activation(): void
    {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $listener = $this->app->make(
            SubscriptionActivatedActivityListener::class
        );

        $listener->handle(
            new SubscriptionActivated($subscription)
        );

        $this->assertDatabaseHas('activity_logs', [
            'tenant_id' => $subscription->tenant_id,
            'module'    => 'subscription',
            'action'    => 'activated',
        ]);

        $activity = ActivityLog::query()
            ->where('tenant_id', $subscription->tenant_id)
            ->where('module', 'subscription')
            ->where('action', 'activated')
            ->first();

        $this->assertNotNull($activity);
        $this->assertSame(
            'Subscription activated successfully.',
            $activity->description
        );
    }

    public function test_listener_ignores_other_events(): void
    {
        $subscription = Subscription::factory()->create([
            'status' => 'active',
        ]);

        $listener = $this->app->make(
            SubscriptionActivatedActivityListener::class
        );

        $listener->handle(
            new SubscriptionRestored($subscription)
        );

        $this->assertDatabaseMissing('activity_logs', [
            'tenant_id' => $subscription->tenant_id,
            'module'    => 'subscription',
            'action'    => 'activated',
        ]);
    }
}
