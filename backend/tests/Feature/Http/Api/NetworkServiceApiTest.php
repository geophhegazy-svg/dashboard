<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Api;

use App\Models\Tenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Area;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class NetworkServiceApiTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenantA;
    private Tenant $tenantB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenantA = Tenant::factory()->create();
        $this->tenantB = Tenant::factory()->create();
    }

    public function test_index_requires_view_permission(): void
    {
        $this->actingAsTenantUser($this->tenantA);

        $response = $this->getJson('/api/network-services');

        $response->assertForbidden();
    }

    public function test_index_returns_only_current_tenant_services(): void
    {
        $this->actingAsTenantUser($this->tenantA, [
            'network_services.view',
        ]);

        $serviceA = NetworkService::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        NetworkService::factory()->create([
            'tenant_id' => $this->tenantB->id,
        ]);

        $response = $this->getJson('/api/network-services');

        $response
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $serviceA->id);
    }

    public function test_show_cannot_access_another_tenant_service(): void
    {
        $this->actingAsTenantUser($this->tenantA, [
            'network_services.view',
        ]);

        $serviceB = NetworkService::factory()->create([
            'tenant_id' => $this->tenantB->id,
        ]);

        $this->getJson("/api/network-services/{$serviceB->id}")
            ->assertNotFound();
    }

    public function test_store_requires_create_permission(): void
    {
        $this->actingAsTenantUser($this->tenantA);

        $customer = Customer::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $device = NetworkDevice::create([
            'tenant_id' => $this->tenantA->id,
            'name' => 'API Test Router',
            'ip_address' => '192.0.2.10',
            'username' => 'api-test',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => false,
        ]);

        $this->postJson('/api/network-services', [
            'tenant_id' => $this->tenantA->id,
            'customer_id' => $customer->id,
            'package_id' => $package->id,
            'network_device_id' => $device->id,
            'connection_type' => 'pppoe',
            'username' => 'permission-test-user',
            'password' => 'secret-password',
            'ip_mode' => 'dynamic',
            'starts_at' => now()->toDateTimeString(),
        ])->assertForbidden();
    }

    public function test_store_creates_network_service(): void
    {
        $this->actingAsTenantUser($this->tenantA, [
            'network_services.create',
        ]);

        $customer = Customer::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $area = Area::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $device = NetworkDevice::create([
            'tenant_id' => $this->tenantA->id,
            'name' => 'API Test Router',
            'ip_address' => '192.0.2.10',
            'username' => 'api-test',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => false,
        ]);

        $payload = [
            'tenant_id' => $this->tenantA->id,
            'customer_id' => $customer->id,
            'area_id' => $area->id,
            'package_id' => $package->id,
            'network_device_id' => $device->id,
            'connection_type' => 'pppoe',
            'username' => 'api-test-user',
            'password' => 'secret-password',
            'mac_address' => 'AA:BB:CC:DD:EE:01',
            'ip_address' => '10.10.10.10',
            'ip_mode' => 'static',
            'starts_at' => now()->toDateTimeString(),
        ];

        $response = $this->postJson('/api/network-services', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('data.tenant_id', $this->tenantA->id)
            ->assertJsonPath('data.customer_id', $customer->id)
            ->assertJsonPath('data.area_id', $area->id)
            ->assertJsonPath('data.package_id', $package->id)
            ->assertJsonPath('data.network_device_id', $device->id)
            ->assertJsonMissingPath('data.password');

        $this->assertDatabaseHas('network_services', [
            'tenant_id' => $this->tenantA->id,
            'customer_id' => $customer->id,
            'username' => 'api-test-user',
        ]);
    }

    public function test_store_rejects_cross_tenant_customer(): void
    {
        $this->actingAsTenantUser($this->tenantA, [
            'network_services.create',
        ]);

        $customerB = Customer::factory()->create([
            'tenant_id' => $this->tenantB->id,
        ]);

        $areaA = Area::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $packageA = Package::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $deviceA = NetworkDevice::create([
            'tenant_id' => $this->tenantA->id,
            'name' => 'API Test Router',
            'ip_address' => '192.0.2.10',
            'username' => 'api-test',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => false,
        ]);

        $response = $this->postJson('/api/network-services', [
            'tenant_id' => $this->tenantA->id,
            'customer_id' => $customerB->id,
            'area_id' => $areaA->id,
            'package_id' => $packageA->id,
            'network_device_id' => $deviceA->id,
            'connection_type' => 'pppoe',
            'username' => 'cross-tenant-user',
            'password' => 'secret-password',
            'ip_mode' => 'dynamic',
            'starts_at' => now()->toDateTimeString(),
        ]);

        $response->assertUnprocessable();

        $this->assertDatabaseMissing('network_services', [
            'username' => 'cross-tenant-user',
        ]);
    }

    public function test_store_rejects_cross_tenant_network_references(): void
    {
        $this->actingAsTenantUser($this->tenantA, [
            'network_services.create',
        ]);

        $customerA = Customer::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $areaB = Area::factory()->create([
            'tenant_id' => $this->tenantB->id,
        ]);

        $packageB = Package::factory()->create([
            'tenant_id' => $this->tenantB->id,
        ]);

        $deviceB = NetworkDevice::create([
            'tenant_id' => $this->tenantB->id,
            'name' => 'Cross Tenant Router',
            'ip_address' => '192.0.2.20',
            'username' => 'cross-tenant',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => false,
        ]);

        $basePayload = [
            'tenant_id' => $this->tenantA->id,
            'customer_id' => $customerA->id,
            'area_id' => $areaB->id,
            'package_id' => $packageB->id,
            'network_device_id' => $deviceB->id,
            'connection_type' => 'pppoe',
            'username' => 'cross-tenant-reference',
            'password' => 'secret-password',
            'ip_mode' => 'dynamic',
            'starts_at' => now()->toDateTimeString(),
        ];

        foreach (['area_id', 'package_id', 'network_device_id'] as $field) {
            $response = $this->postJson(
                '/api/network-services',
                $basePayload
            );

            $response->assertUnprocessable();

            $this->assertDatabaseMissing('network_services', [
                'username' => 'cross-tenant-reference',
            ]);

            $basePayload['username'] .= '-next';
        }
    }

    public function test_update_rejects_cross_tenant_network_references(): void
    {
        $this->actingAsTenantUser($this->tenantA, [
            'network_services.update',
        ]);

        $customerA = Customer::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $areaA = Area::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $packageA = Package::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $deviceA = NetworkDevice::create([
            'tenant_id' => $this->tenantA->id,
            'name' => 'Update Test Router A',
            'ip_address' => '192.0.2.20',
            'username' => 'update-test-a',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => false,
        ]);

        $networkService = NetworkService::factory()->create([
            'tenant_id' => $this->tenantA->id,
            'customer_id' => $customerA->id,
            'area_id' => $areaA->id,
            'package_id' => $packageA->id,
            'network_device_id' => $deviceA->id,
        ]);

        $areaB = Area::factory()->create([
            'tenant_id' => $this->tenantB->id,
        ]);

        $packageB = Package::factory()->create([
            'tenant_id' => $this->tenantB->id,
        ]);

        $deviceB = NetworkDevice::create([
            'tenant_id' => $this->tenantB->id,
            'name' => 'Update Test Router B',
            'ip_address' => '192.0.2.21',
            'username' => 'update-test-b',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => false,
        ]);

        $basePayload = [
            'customer_id' => $customerA->id,
            'area_id' => $areaA->id,
            'package_id' => $packageA->id,
            'network_device_id' => $deviceA->id,
            'connection_type' => 'pppoe',
            'username' => 'update-cross-tenant-test',
            'password' => 'secret-password',
            'ip_mode' => 'dynamic',
            'starts_at' => now()->toDateTimeString(),
        ];

        foreach ([
            'area_id' => $areaB->id,
            'package_id' => $packageB->id,
            'network_device_id' => $deviceB->id,
        ] as $field => $value) {
            $payload = $basePayload;
            $payload[$field] = $value;

            $response = $this->putJson(
                "/api/network-services/{$networkService->id}",
                $payload
            );

            $response->assertUnprocessable();

            $this->assertDatabaseHas('network_services', [
                'id' => $networkService->id,
                $field => match ($field) {
                    'area_id' => $areaA->id,
                    'package_id' => $packageA->id,
                    'network_device_id' => $deviceA->id,
                },
            ]);
        }
    }

    public function test_update_requires_update_permission(): void
    {
        $service = NetworkService::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $this->actingAsTenantUser($this->tenantA);

        $this->patchJson("/api/network-services/{$service->id}", [
            'username' => 'updated-user',
        ])->assertForbidden();
    }

    public function test_update_cannot_change_status(): void
    {
        $service = NetworkService::factory()->create([
            'tenant_id' => $this->tenantA->id,
            'status' => 'pending',
        ]);

        $this->actingAsTenantUser($this->tenantA, [
            'network_services.update',
        ]);

        $this->patchJson("/api/network-services/{$service->id}", [
            'status' => 'active',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['status']);
    }

    public function test_delete_requires_delete_permission(): void
    {
        $service = NetworkService::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $this->actingAsTenantUser($this->tenantA);

        $this->deleteJson("/api/network-services/{$service->id}")
            ->assertForbidden();
    }

    public function test_delete_removes_network_service(): void
    {
        $service = NetworkService::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $this->actingAsTenantUser($this->tenantA, [
            'network_services.delete',
        ]);

        $this->deleteJson("/api/network-services/{$service->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('network_services', [
            'id' => $service->id,
        ]);
    }

    public function test_provision_requires_provision_permission(): void
    {
        $service = NetworkService::factory()->create([
            'tenant_id' => $this->tenantA->id,
        ]);

        $this->actingAsTenantUser($this->tenantA);

        $this->postJson("/api/network-services/{$service->id}/provision")
            ->assertForbidden();
    }

    public function test_provision_cannot_access_another_tenant_service(): void
    {
        $serviceB = NetworkService::factory()->create([
            'tenant_id' => $this->tenantB->id,
        ]);

        $this->actingAsTenantUser($this->tenantA, [
            'network_services.provision',
        ]);

        $this->postJson("/api/network-services/{$serviceB->id}/provision")
            ->assertNotFound();
    }

    /**
     * @param array<int, string> $permissions
     */
    private function actingAsTenantUser(
        Tenant $tenant,
        array $permissions = [],
    ): void {
        $user = \App\Models\User::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        if ($permissions !== []) {
            $user->givePermissionTo($permissions);
        }

        $this->actingAs($user);
    }
}
