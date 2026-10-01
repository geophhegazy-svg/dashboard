<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Network;

use App\Models\Tenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Area;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\QueryException;
use Tests\TestCase;

class NetworkServiceFoundationContractTest extends TestCase
{
    use RefreshDatabase;

    public function test_area_contract_is_tenant_scoped(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $areaA = Area::create([
            'tenant_id' => $tenantA->id,
            'name' => 'Area 1',
            'code' => 'A1',
            'status' => 'active',
        ]);

        $this->assertSame($tenantA->id, $areaA->tenant_id);
        $this->assertInstanceOf(Tenant::class, $areaA->tenant);
        $this->assertSame($tenantA->id, $areaA->tenant->id);

        $areaB = Area::create([
            'tenant_id' => $tenantB->id,
            'name' => 'Area 1',
            'code' => 'A1',
            'status' => 'active',
        ]);

        $this->assertNotSame($areaA->id, $areaB->id);
        $this->assertSame($tenantB->id, $areaB->tenant_id);
    }

    public function test_area_name_is_unique_within_the_same_tenant(): void
    {
        $tenant = Tenant::factory()->create();

        Area::create([
            'tenant_id' => $tenant->id,
            'name' => 'Area 1',
            'code' => 'A1',
        ]);

        $this->expectException(QueryException::class);

        Area::create([
            'tenant_id' => $tenant->id,
            'name' => 'Area 1',
            'code' => 'A2',
        ]);
    }

    public function test_network_service_foundation_contract(): void
    {
        $tenant = Tenant::factory()->create();

        $customer = Customer::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $area = Area::create([
            'tenant_id' => $tenant->id,
            'name' => 'Area 1',
            'code' => 'A1',
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $device = NetworkDevice::create([
            'name' => 'Test MikroTik',
            'ip_address' => '192.168.88.1',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => false,
        ]);

        $service = NetworkService::create([
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'area_id' => $area->id,
            'package_id' => $package->id,
            'network_device_id' => $device->id,
            'connection_type' => 'pppoe',
            'username' => 'customer001',
            'password' => 'secret-password',
            'mac_address' => 'AA:BB:CC:DD:EE:FF',
            'ip_address' => '10.10.10.10',
            'ip_mode' => 'static',
            'starts_at' => '2026-10-01 08:00:00',
            'ends_at' => '2026-11-01 08:00:00',
        ]);

        $this->assertSame($tenant->id, $service->tenant_id);
        $this->assertSame($customer->id, $service->customer_id);
        $this->assertSame($area->id, $service->area_id);
        $this->assertSame($package->id, $service->package_id);
        $this->assertSame($device->id, $service->network_device_id);

        $this->assertInstanceOf(Customer::class, $service->customer);
        $this->assertInstanceOf(Area::class, $service->area);
        $this->assertInstanceOf(Package::class, $service->package);
        $this->assertInstanceOf(NetworkDevice::class, $service->networkDevice);
        $this->assertInstanceOf(Tenant::class, $service->tenant);

        $this->assertSame('secret-password', $service->getAttribute('password'));
        $this->assertContains('password', $service->getHidden());

        $this->assertInstanceOf(
            \Illuminate\Support\Carbon::class,
            $service->starts_at
        );

        $this->assertInstanceOf(
            \Illuminate\Support\Carbon::class,
            $service->ends_at
        );

        $service->refresh();

        $this->assertSame('pending', $service->status);
        $this->assertSame('pending', $service->provisioning_status);
    }

    public function test_network_service_factory_preserves_tenant_consistency(): void
    {
        $service = NetworkService::factory()->create();

        $this->assertNotNull($service->tenant_id);
        $this->assertNotNull($service->customer);
        $this->assertNotNull($service->area);
        $this->assertNotNull($service->package);

        $this->assertSame(
            $service->tenant_id,
            $service->customer->tenant_id
        );

        $this->assertSame(
            $service->tenant_id,
            $service->area->tenant_id
        );

        $this->assertSame(
            $service->tenant_id,
            $service->package->tenant_id
        );
    }

    public function test_network_service_subscription_relationship_contract(): void
    {
        $tenant = Tenant::factory()->create();

        $customer = Customer::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $service = NetworkService::create([
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'package_id' => $package->id,
            'connection_type' => 'pppoe',
            'username' => 'contract-pppoe-user',
            'starts_at' => '2026-10-01 08:00:00',
        ]);

        $subscription = Subscription::create([
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'package_id' => $package->id,
            'network_service_id' => $service->id,
            'start_date' => '2026-10-01',
            'end_date' => '2026-11-01',
            'monthly_price' => '100.00',
            'status' => 'active',
            'pppoe_username' => 'legacy-pppoe-user',
            'pppoe_password' => 'legacy-password',
            'mikrotik_profile' => 'default',
        ]);

        $hotspotSubscription = HotspotSubscription::create([
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'package_id' => $package->id,
            'network_service_id' => $service->id,
            'hotspot_username' => 'legacy-hotspot-user',
            'hotspot_password' => 'legacy-password',
            'mikrotik_profile' => 'default',
            'start_date' => '2026-10-01',
            'end_date' => '2026-11-01',
            'monthly_price' => '100.00',
            'status' => 'active',
        ]);

        $subscription->refresh();
        $hotspotSubscription->refresh();
        $service->refresh();

        $this->assertSame($service->id, $subscription->network_service_id);
        $this->assertSame($service->id, $hotspotSubscription->network_service_id);

        $this->assertInstanceOf(
            NetworkService::class,
            $subscription->networkService
        );

        $this->assertInstanceOf(
            NetworkService::class,
            $hotspotSubscription->networkService
        );

        $this->assertSame(
            $service->id,
            $subscription->networkService->id
        );

        $this->assertSame(
            $service->id,
            $hotspotSubscription->networkService->id
        );

        $this->assertTrue(
            $service->subscriptions->contains(
                fn (Subscription $item): bool => $item->id === $subscription->id
            )
        );

        $this->assertTrue(
            $service->hotspotSubscriptions->contains(
                fn (HotspotSubscription $item): bool => $item->id === $hotspotSubscription->id
            )
        );
    }

    public function test_network_service_can_be_scoped_to_different_tenants(): void
    {
        $tenantA = Tenant::factory()->create();
        $tenantB = Tenant::factory()->create();

        $customerA = Customer::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $customerB = Customer::factory()->create([
            'tenant_id' => $tenantB->id,
        ]);

        $areaA = Area::create([
            'tenant_id' => $tenantA->id,
            'name' => 'Area A',
        ]);

        $areaB = Area::create([
            'tenant_id' => $tenantB->id,
            'name' => 'Area B',
        ]);

        $packageA = Package::factory()->create([
            'tenant_id' => $tenantA->id,
        ]);

        $packageB = Package::factory()->create([
            'tenant_id' => $tenantB->id,
        ]);

        $serviceA = NetworkService::create([
            'tenant_id' => $tenantA->id,
            'customer_id' => $customerA->id,
            'area_id' => $areaA->id,
            'package_id' => $packageA->id,
            'connection_type' => 'pppoe',
            'username' => 'tenant-a-user',
            'starts_at' => now(),
        ]);

        $serviceB = NetworkService::create([
            'tenant_id' => $tenantB->id,
            'customer_id' => $customerB->id,
            'area_id' => $areaB->id,
            'package_id' => $packageB->id,
            'connection_type' => 'hotspot',
            'username' => 'tenant-b-user',
            'starts_at' => now(),
        ]);

        $this->assertNotSame($serviceA->tenant_id, $serviceB->tenant_id);
        $this->assertSame($tenantA->id, $serviceA->tenant_id);
        $this->assertSame($tenantB->id, $serviceB->tenant_id);
    }
}

