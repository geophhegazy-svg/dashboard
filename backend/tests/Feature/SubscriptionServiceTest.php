<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Domain\Events\SubscriptionExpired;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Subscription\Domain\Events\SubscriptionRestored;
use App\Modules\Subscription\Domain\Events\SubscriptionSuspended;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Services\Subscription\SubscriptionService;
use App\Contracts\MikrotikServiceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\Fakes\FakeMikrotikService;
use Tests\TestCase;

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

    private function createSubscription(
        array $attributes = []
    ): Subscription {

        return Subscription::factory()->create(
            array_merge([
                'status' => SubscriptionStatus::ACTIVE,
                'pppoe_username' => 'customer1',
            ], $attributes)
        );
    }

    public function test_activate_subscription_changes_status_to_active(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => SubscriptionStatus::SUSPENDED,
        ]);

        $service = app(SubscriptionService::class);

        $subscription = $service->activate(
            $subscription
        );

        $this->assertInstanceOf(
            Subscription::class,
            $subscription
        );

        $this->assertEquals(
            SubscriptionStatus::ACTIVE,
            $subscription->status
        );

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        $this->assertContains(
            'customer1',
            $fake->enabledUsers
        );
    }

    public function test_suspend_subscription_changes_status_to_suspended(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription();

        $service = app(SubscriptionService::class);

        $subscription = $service->suspend(
            $subscription
        );

        $this->assertEquals(
            SubscriptionStatus::SUSPENDED,
            $subscription->status
        );

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => SubscriptionStatus::SUSPENDED->value,
        ]);

        $this->assertContains(
            'customer1',
            $fake->disabledUsers
        );
    }

    public function test_expire_subscription_changes_status_to_expired(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription();

        $service = app(SubscriptionService::class);

        $subscription = $service->expire(
            $subscription
        );

        $this->assertEquals(
            SubscriptionStatus::EXPIRED,
            $subscription->status
        );

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => SubscriptionStatus::EXPIRED->value,
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
            'status' => SubscriptionStatus::EXPIRED,
        ]);

        $service = app(SubscriptionService::class);

        $subscription = $service->restore(
            $subscription
        );

        $this->assertEquals(
            SubscriptionStatus::ACTIVE,
            $subscription->status
        );

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => SubscriptionStatus::ACTIVE->value,
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
            'status' => SubscriptionStatus::EXPIRED,
        ]);

        $oldEndDate = $subscription->end_date;

        $service = app(SubscriptionService::class);

        $subscription = $service->renew(
            $subscription,
            30
        );

        $this->assertInstanceOf(
            Subscription::class,
            $subscription
        );

        $this->assertEquals(
            SubscriptionStatus::ACTIVE,
            $subscription->status
        );

        $this->assertNotEquals(
            $oldEndDate,
            $subscription->end_date
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
            'status' => SubscriptionStatus::SUSPENDED,
            'pppoe_username' => null,
        ]);

        $service = app(SubscriptionService::class);

        $subscription = $service->activate(
            $subscription
        );

        $this->assertEquals(
            SubscriptionStatus::ACTIVE,
            $subscription->status
        );

        $this->assertEmpty(
            $fake->enabledUsers
        );
    }

    public function test_suspend_subscription_without_pppoe_user(): void
    {
        $fake = $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'pppoe_username' => null,
        ]);

        $service = app(SubscriptionService::class);

        $subscription = $service->suspend(
            $subscription
        );

        $this->assertEquals(
            SubscriptionStatus::SUSPENDED,
            $subscription->status
        );

        $this->assertEmpty(
            $fake->disabledUsers
        );
    }

    public function test_activate_dispatches_event(): void
    {
        Event::fake();

        $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => SubscriptionStatus::SUSPENDED,
        ]);

        app(SubscriptionService::class)
            ->activate($subscription);

        Event::assertDispatched(
            SubscriptionActivated::class
        );
    }

    public function test_suspend_dispatches_event(): void
    {
        Event::fake();

        $this->fakeMikrotik();

        $subscription = $this->createSubscription();

        app(SubscriptionService::class)
            ->suspend($subscription);

        Event::assertDispatched(
            SubscriptionSuspended::class
        );
    }

    public function test_expire_dispatches_event(): void
    {
        Event::fake();

        $this->fakeMikrotik();

        $subscription = $this->createSubscription();

        app(SubscriptionService::class)
            ->expire($subscription);

        Event::assertDispatched(
            SubscriptionExpired::class
        );
    }

    public function test_restore_dispatches_event(): void
    {
        Event::fake();

        $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => SubscriptionStatus::EXPIRED,
        ]);

        app(SubscriptionService::class)
            ->restore($subscription);

        Event::assertDispatched(
            SubscriptionRestored::class
        );
    }

    public function test_renew_dispatches_event(): void
    {
        Event::fake();

        $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => SubscriptionStatus::EXPIRED,
        ]);

        app(SubscriptionService::class)
            ->renew($subscription);

        Event::assertDispatched(
            SubscriptionRenewed::class
        );
    }

    public function test_activate_rolls_back_when_mikrotik_fails(): void
    {
        $fake = $this->fakeMikrotik();

        $fake->failOnEnable = true;

        $subscription = $this->createSubscription([
            'status' => SubscriptionStatus::SUSPENDED,
        ]);

        $this->expectException(
            \RuntimeException::class
        );

        app(SubscriptionService::class)
            ->activate($subscription);

        $subscription->refresh();

        $this->assertEquals(
            SubscriptionStatus::SUSPENDED,
            $subscription->status
        );
    }

    public function test_renew_updates_expiration_date(): void
    {
        $this->fakeMikrotik();

        $subscription = $this->createSubscription([
            'status' => SubscriptionStatus::EXPIRED,
        ]);

        $oldDate = $subscription->end_date;

        $subscription = app(
            SubscriptionService::class
        )->renew(
            $subscription,
            30
        );

        $this->assertNotEquals(
            $oldDate,
            $subscription->end_date
        );

        $this->assertTrue(
            $subscription->end_date->isFuture()
        );
    }
}

