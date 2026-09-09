<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use Tests\Fakes\FakeMikrotikService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class SubscriptionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->instance(
            MikrotikServiceInterface::class,
            new FakeMikrotikService()
        );
    }

    private function actingAsUser(): void
    {
        $user = User::factory()->create();

        $permissions = [
            'subscriptions.activate',
            'subscriptions.suspend',
            'subscriptions.renew',
            'subscriptions.restore',
            'subscriptions.expire',
            'subscriptions.cancel',
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

        $subscription = Subscription::factory()->suspended()->create();

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

        $subscription = Subscription::factory()->active()->create();

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

        $subscription = Subscription::factory()->expired()->create();

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

        $subscription = Subscription::factory()->expired()->create();

        $this->postJson(
            "/api/subscriptions/{$subscription->id}/restore"
        )
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Subscription restored successfully',
            ]);
    }

    public function test_cancel_endpoint_returns_success(): void
    {
        $this->actingAsUser();

        $subscription = Subscription::factory()->active()->create();

        $this->postJson(
            "/api/subscriptions/{$subscription->id}/cancel"
        )
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Subscription cancelled successfully',
            ]);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_expire_endpoint_returns_success(): void
    {
        $this->actingAsUser();

        $subscription = Subscription::factory()->active()->create();

        $this->postJson(
            "/api/subscriptions/{$subscription->id}/expire"
        )
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Subscription expired successfully',
            ]);
    }
}
