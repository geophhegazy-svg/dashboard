<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\User;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsUser(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);
    }

    public function test_activate_endpoint_returns_success(): void
    {
        $this->actingAsUser();

        $subscription = Subscription::factory()->create();

        $service = Mockery::mock(SubscriptionService::class);

        $service->shouldReceive('activate')
            ->once()
            ->with(Mockery::type(Subscription::class))
            ->andReturn(true);

        $this->app->instance(
            SubscriptionService::class,
            $service
        );

        $response = $this->postJson(
            "/api/subscriptions/{$subscription->id}/activate"
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Subscription activated successfully',
            ]);
    }

    public function test_suspend_endpoint_returns_success(): void
    {
        $this->actingAsUser();

        $subscription = Subscription::factory()->create();

        $service = Mockery::mock(SubscriptionService::class);

        $service->shouldReceive('suspend')
            ->once()
            ->with(Mockery::type(Subscription::class))
            ->andReturn(true);

        $this->app->instance(
            SubscriptionService::class,
            $service
        );

        $response = $this->postJson(
            "/api/subscriptions/{$subscription->id}/suspend"
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Subscription suspended successfully',
            ]);
    }

    public function test_renew_endpoint_returns_success(): void
    {
        $this->actingAsUser();

        $subscription = Subscription::factory()->create();

        $service = Mockery::mock(SubscriptionService::class);

        $service->shouldReceive('renew')
            ->once()
            ->with(
                Mockery::type(Subscription::class),
                30
            )
            ->andReturn(true);

        $this->app->instance(
            SubscriptionService::class,
            $service
        );

        $response = $this->postJson(
            "/api/subscriptions/{$subscription->id}/renew",
            [
                'days' => 30,
            ]
        );

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Subscription renewed successfully',
            ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
