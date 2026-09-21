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
                'mikrotik_profile' => 'default',
            ])
            ->assertForbidden();

        self::assertDatabaseMissing('hotspot_subscriptions', [
            'customer_id' => $customer->id,
            'tenant_id' => $tenantB->id,
        ]);
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
                'mikrotik_profile' => 'default',
            ])
            ->assertCreated();

        self::assertDatabaseHas('hotspot_subscriptions', [
            'customer_id' => $customer->id,
            'tenant_id' => $tenantB->id,
        ]);
    }
}
