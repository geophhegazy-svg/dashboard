<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Fakes\FakeMikrotikService;
use App\Models\Subscription;
use App\Contracts\MikrotikServiceInterface;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use App\Events\SubscriptionActivated;
use App\Enums\SubscriptionStatus;

class SubscriptionServiceTest extends TestCase
{
    use RefreshDatabase;

    private function fakeMikrotik(): FakeMikrotikService
    {
        $fake = new FakeMikrotikService();

        $this->app->instance(
            MikrotikServiceInterface::class,
            $fake
        );

        return $fake;
    }

    private function createSubscription(array $attributes = []): Subscription
    {
        return Subscription::factory()->create(array_merge([
            'status' => 'active',
            'pppoe_username' => 'customer1',
        ], $attributes));
    }

    public function test_activate_subscription_changes_status_to_active(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => 'suspended',
        ]);

        $service = app(SubscriptionService::class);

        $result = $service->activate($subscription);

        $this->assertTrue($result);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'active',
        ]);

        $this->assertContains(
            'customer1',
            $fake->enabledUsers
        );
    }

    public function test_suspend_subscription_changes_status_to_suspended(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => 'active',
        ]);

        $service = app(SubscriptionService::class);

        $result = $service->suspend($subscription);

        $this->assertTrue($result);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'suspended',
        ]);

        $this->assertContains(
            'customer1',
            $fake->disabledUsers
        );
    }

    public function test_expire_subscription_changes_status_to_expired(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => 'active',
        ]);

        $service = app(SubscriptionService::class);

        $result = $service->expire($subscription);

        $this->assertTrue($result);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'expired',
        ]);

        $this->assertContains(
            'customer1',
            $fake->disabledUsers
        );
    }

    public function test_restore_subscription_changes_status_to_active(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => 'expired',
        ]);

        $service = app(SubscriptionService::class);

        $result = $service->restore($subscription);

        $this->assertTrue($result);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'active',
        ]);

        $this->assertContains(
            'customer1',
            $fake->enabledUsers
        );
    }

    public function test_renew_subscription_changes_status_to_active(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => 'expired',
        ]);

        $service = app(SubscriptionService::class);

        $result = $service->renew($subscription);

        $this->assertTrue($result);

        $subscription->refresh();

        $this->assertEquals(
            \App\Enums\SubscriptionStatus::ACTIVE,
            $subscription->status
        );

        $this->assertContains(
            'customer1',
            $fake->enabledUsers
        );
    }

    public function test_activate_subscription_without_pppoe_user(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => 'suspended',
            'pppoe_username' => null,
        ]);

        $service = app(SubscriptionService::class);

        $result = $service->activate($subscription);

        $this->assertTrue($result);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'active',
        ]);

        $this->assertEmpty($fake->enabledUsers);
    }

    public function test_suspend_subscription_without_pppoe_user(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'pppoe_username' => null,
        ]);

        $service = app(SubscriptionService::class);

        $service->suspend($subscription);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'suspended',
        ]);

        $this->assertEmpty($fake->disabledUsers);
    }

    public function test_activate_dispatches_event(): void
    {
        Event::fake();

        $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => 'suspended',
        ]);

        $service = app(SubscriptionService::class);

        $service->activate($subscription);

        Event::assertDispatched(
            SubscriptionActivated::class
        );
    }

    public function test_activate_rolls_back_when_mikrotik_fails(): void
    {
        $fake = $this->fakeMikrotik();

        $fake->failOnEnable = true;

        $subscription = $this->createSubscription([
            'status' => 'suspended',
        ]);

        $service = app(SubscriptionService::class);

        try {
            $service->activate($subscription);

            $this->fail('RuntimeException was expected.');
        } catch (\RuntimeException $e) {
            // Expected
        }

        $subscription->refresh();

        $this->assertEquals(
            \App\Enums\SubscriptionStatus::SUSPENDED,
            $subscription->status
        );
    }
    public function test_suspend_dispatches_event(): void
    {
        Event::fake();

        $this->fakeMikrotik();

        $subscription = $this->createSubscription();

        $service = app(SubscriptionService::class);

        $service->suspend($subscription);

        Event::assertDispatched(
            \App\Events\SubscriptionSuspended::class
        );
    }

    public function test_renew_dispatches_event(): void
    {
        Event::fake();

        $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => 'expired',
        ]);

        $service = app(SubscriptionService::class);

        $service->renew($subscription);

        Event::assertDispatched(
            \App\Events\SubscriptionRenewed::class
        );
    }

    public function test_renew_updates_expiration_date(): void
    {
        $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => 'expired',
        ]);

        $oldDate = $subscription->end_date;

        $service = app(SubscriptionService::class);

        $service->renew($subscription, 30);

        $subscription->refresh();

        $this->assertNotEquals(
            $oldDate,
            $subscription->end_date
        );

        $this->assertTrue(
            $subscription->end_date->greaterThan(now())
        );
    }
}
