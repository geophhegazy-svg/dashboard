<?php

declare(strict_types=1);

namespace Tests\Feature\Security;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class HotspotSubscriptionTenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_user_cannot_create_hotspot_subscription_for_another_tenant(): void
    {
        Permission::findOrCreate('subscriptions.create', 'web');

        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $actor->givePermissionTo('subscriptions.create');

        $customer = Customer::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $this->actingAs($actor, 'sanctum')
            ->postJson('/api/hotspot-subscriptions', [
                'tenant_id' => $tenantB->id,
                'customer_id' => $customer->id,
                'package_id' => $package->id,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonth()->toDateString(),
                'monthly_price' => 100,
                'hotspot_username' => 'tenant-b-user',
                'hotspot_password' => 'TenantPass123',
                'mikrotik_profile' => 'default',
            ])
            ->assertForbidden();

        self::assertDatabaseMissing('hotspot_subscriptions', [
            'customer_id' => $customer->id,
            'tenant_id' => $tenantB->id,
        ]);
    }


    public function test_hotspot_subscription_requires_username_and_password(): void
    {
        Permission::findOrCreate('subscriptions.create', 'web');

        $tenant = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $actor->givePermissionTo('subscriptions.create');

        $customer = Customer::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $payload = [
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'package_id' => $package->id,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'monthly_price' => 100,
            'mikrotik_profile' => 'default',
        ];

        $this->actingAs($actor, 'sanctum')
            ->postJson('/api/hotspot-subscriptions', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'hotspot_username',
                'hotspot_password',
            ]);
    }

    public function test_hotspot_subscription_accepts_and_persists_credentials(): void
    {
        Permission::findOrCreate('subscriptions.create', 'web');

        $tenant = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $actor->givePermissionTo('subscriptions.create');

        $customer = Customer::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $this->actingAs($actor, 'sanctum')
            ->postJson('/api/hotspot-subscriptions', [
                'tenant_id' => $tenant->id,
                'customer_id' => $customer->id,
                'package_id' => $package->id,
                'hotspot_username' => 'contract-user-01',
                'hotspot_password' => 'ContractPass123',
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonth()->toDateString(),
                'monthly_price' => 100,
                'mikrotik_profile' => 'default',
            ])
            ->assertCreated();

        self::assertDatabaseHas('hotspot_subscriptions', [
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'hotspot_username' => 'contract-user-01',
            'hotspot_password' => 'ContractPass123',
        ]);
    }

    public function test_hotspot_subscription_rejects_duplicate_username(): void
    {
        Permission::findOrCreate('subscriptions.create', 'web');

        $tenant = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $actor->givePermissionTo('subscriptions.create');

        $customer = Customer::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $basePayload = [
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'package_id' => $package->id,
            'hotspot_username' => 'duplicate-user',
            'hotspot_password' => 'ContractPass123',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'monthly_price' => 100,
            'mikrotik_profile' => 'default',
        ];

        $this->actingAs($actor, 'sanctum')
            ->postJson('/api/hotspot-subscriptions', $basePayload)
            ->assertCreated();

        $this->actingAs($actor, 'sanctum')
            ->postJson('/api/hotspot-subscriptions', $basePayload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['hotspot_username']);
    }

    public function test_super_admin_can_create_hotspot_subscription_for_another_tenant(): void
    {
        Permission::findOrCreate('subscriptions.create', 'web');

        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $actor = User::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $actor->assignRole('Super Admin');
        $actor->givePermissionTo('subscriptions.create');

        $customer = Customer::factory()->create([
            'tenant_id' => $tenantB->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $tenantB->id,
        ]);

        $this->actingAs($actor, 'sanctum')
            ->postJson('/api/hotspot-subscriptions', [
                'tenant_id' => $tenantB->id,
                'customer_id' => $customer->id,
                'package_id' => $package->id,
                'start_date' => now()->toDateString(),
                'end_date' => now()->addMonth()->toDateString(),
                'monthly_price' => 100,
                'hotspot_username' => 'tenant-a-user',
                'hotspot_password' => 'TenantPass123',
                'mikrotik_profile' => 'default',
            ])
            ->assertCreated();

        self::assertDatabaseHas('hotspot_subscriptions', [
            'customer_id' => $customer->id,
            'tenant_id' => $tenantB->id,
        ]);
    }
}
