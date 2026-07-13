<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\User;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsUser(): void
    {
        $user = User::factory()->create();

        $permissions = [
            'subscriptions.activate',
            'subscriptions.suspend',
            'subscriptions.renew',
            'subscriptions.restore',
            'subscriptions.expire',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $user->givePermissionTo($permissions);

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
            ->andReturn($subscription);

        $this->app->instance(
            SubscriptionService::class,
            $service
        );

        $this->postJson(
            "/api/subscriptions/{$subscription->id}/activate"
        )
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
            ->andReturn($subscription);

        $this->app->instance(
            SubscriptionService::class,
            $service
        );

        $this->postJson(
            "/api/subscriptions/{$subscription->id}/suspend"
        )
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
            ->andReturn($subscription);

        $this->app->instance(
            SubscriptionService::class,
            $service
        );

        $this->postJson(
            "/api/subscriptions/{$subscription->id}/renew",
            [
                'days' => 30,
            ]
        )
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Subscription renewed successfully',
            ]);
    }

    public function test_restore_endpoint_returns_success(): void
    {
        $this->actingAsUser();

        $subscription = Subscription::factory()->create();

        $service = Mockery::mock(SubscriptionService::class);

        $service->shouldReceive('restore')
            ->once()
            ->with(Mockery::type(Subscription::class))
            ->andReturn($subscription);

        $this->app->instance(
            SubscriptionService::class,
            $service
        );

        $this->postJson(
            "/api/subscriptions/{$subscription->id}/restore"
        )
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Subscription restored successfully',
            ]);
    }

    public function test_expire_endpoint_returns_success(): void
    {
        $this->actingAsUser();

        $subscription = Subscription::factory()->create();

        $service = Mockery::mock(SubscriptionService::class);

        $service->shouldReceive('expire')
            ->once()
            ->with(Mockery::type(Subscription::class))
            ->andReturn($subscription);

        $this->app->instance(
            SubscriptionService::class,
            $service
        );

        $this->postJson(
            "/api/subscriptions/{$subscription->id}/expire"
        )
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Subscription expired successfully',
            ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
