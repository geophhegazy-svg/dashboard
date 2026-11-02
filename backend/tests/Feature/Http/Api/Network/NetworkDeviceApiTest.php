<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Api\Network;

use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

final class NetworkDeviceApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_only_active_devices_for_current_tenant(): void
    {
        $tenant = Tenant::factory()->create();
        $otherTenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $permission = Permission::findOrCreate(
            'network_services.create',
            'web',
        );

        $user->givePermissionTo($permission);

        $visible = NetworkDevice::query()->create([
            'tenant_id' => $tenant->id,
            'name' => 'Tenant MikroTik',
            'ip_address' => '10.10.10.1',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => true,
        ]);

        NetworkDevice::query()->create([
            'tenant_id' => $tenant->id,
            'name' => 'Inactive MikroTik',
            'ip_address' => '10.10.10.2',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'inactive',
            'is_online' => false,
        ]);

        NetworkDevice::query()->create([
            'tenant_id' => $otherTenant->id,
            'name' => 'Other Tenant MikroTik',
            'ip_address' => '10.20.20.1',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->getJson('/api/network-devices');

        $response
            ->assertOk()
            ->assertJsonPath('data.0.id', $visible->id)
            ->assertJsonPath('data.0.name', 'Tenant MikroTik')
            ->assertJsonPath('data.0.type', 'mikrotik')
            ->assertJsonPath('data.0.status', 'active')
            ->assertJsonPath('data.0.is_online', true);

        $response->assertJsonCount(1, 'data');

        $response->assertJsonMissing([
            'name' => 'Inactive MikroTik',
        ]);

        $response->assertJsonMissing([
            'name' => 'Other Tenant MikroTik',
        ]);

        $response->assertJsonMissing([
            'password' => 'secret',
        ]);
    }

    public function test_index_requires_network_service_create_permission(): void
    {
        $tenant = Tenant::factory()->create();

        $user = User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->getJson('/api/network-devices');

        $response->assertForbidden();
    }
}
