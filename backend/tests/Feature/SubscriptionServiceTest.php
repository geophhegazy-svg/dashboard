<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Fakes\FakeMikrotikService;
use App\Models\Subscription;
use App\Contracts\MikrotikServiceInterface;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_activate_subscription_changes_status_to_active(): void
    {
        $fake = new FakeMikrotikService();

        $this->app->instance(
            MikrotikServiceInterface::class,
            $fake
        );

        $subscription = Subscription::factory()->create([
            'status' => 'suspended',
            'pppoe_username' => 'customer1',
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
}
