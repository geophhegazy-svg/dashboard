<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubscriptionCrudControllerTest extends TestCase
{
    use RefreshDatabase;

    private function login(): void
    {
        $user = User::factory()->create();

        $user->assignRole('Super Admin');

        Sanctum::actingAs($user);
    }

    private function subscriptionDependencies(): array
    {
        $tenant = Tenant::factory()->create();

        $customer = Customer::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        return [
            'tenant' => $tenant,
            'customer' => $customer,
            'package' => $package,
        ];
    }

    public function test_index_returns_subscriptions(): void
    {
        $this->login();

        Subscription::factory()->count(3)->create();

        $this->getJson('/api/subscriptions')
            ->assertOk()
            ->assertJsonStructure([
                'data',
                'links',
                'meta',
            ]);
    }

    public function test_store_creates_subscription(): void
    {
        $this->login();

        $dependencies = $this->subscriptionDependencies();

        $this->postJson('/api/subscriptions', [
            'tenant_id' => $dependencies['tenant']->id,
            'customer_id' => $dependencies['customer']->id,
            'package_id' => $dependencies['package']->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'monthly_price' => 500,
            'status' => 'pending',
            'notes' => 'CRUD test subscription',
            'pppoe_username' => 'crud-test-user',
            'pppoe_password' => 'secret123',
            'mikrotik_profile' => 'default',
        ])
            ->assertSuccessful()
            ->assertJsonStructure([
                'data',
            ]);

        $this->assertDatabaseHas('subscriptions', [
            'tenant_id' => $dependencies['tenant']->id,
            'customer_id' => $dependencies['customer']->id,
            'package_id' => $dependencies['package']->id,
            'status' => 'pending',
            'pppoe_username' => 'crud-test-user',
        ]);
    }

    public function test_show_returns_subscription(): void
    {
        $this->login();

        $subscription = Subscription::factory()->create();

        $this->getJson(
            "/api/subscriptions/{$subscription->id}"
        )
            ->assertOk()
            ->assertJsonPath(
                'data.id',
                $subscription->id
            );
    }

    public function test_update_updates_subscription_without_changing_status(): void
    {
        $this->login();

        $subscription = Subscription::factory()->active()->create([
            'notes' => 'Before update',
        ]);

        $this->putJson(
            "/api/subscriptions/{$subscription->id}",
            [
                'notes' => 'After update',
                'monthly_price' => 600,
            ]
        )
            ->assertOk()
            ->assertJsonPath(
                'data.id',
                $subscription->id
            );

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'notes' => 'After update',
            'monthly_price' => 600,
            'status' => 'active',
        ]);
    }

    public function test_update_rejects_status_change(): void
    {
        $this->login();

        $subscription = Subscription::factory()->active()->create();

        $this->putJson(
            "/api/subscriptions/{$subscription->id}",
            [
                'status' => 'cancelled',
            ]
        )
            ->assertStatus(422);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'active',
        ]);
    }

    public function test_delete_removes_subscription(): void
    {
        $this->login();

        $subscription = Subscription::factory()->create();

        $this->deleteJson(
            "/api/subscriptions/{$subscription->id}"
        )
            ->assertNoContent();

        $this->assertDatabaseMissing('subscriptions', [
            'id' => $subscription->id,
        ]);
    }
}