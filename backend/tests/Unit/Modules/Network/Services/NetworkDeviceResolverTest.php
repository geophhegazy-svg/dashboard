<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Services;

use App\Modules\Network\Application\Services\NetworkDeviceResolver;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

final class NetworkDeviceResolverTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_resolves_the_single_active_global_mikrotik_device(): void
    {
        $device = NetworkDevice::create([
            'tenant_id' => null,
            'name' => 'MikroTik Global',
            'ip_address' => '2.2.2.2',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
        ]);

        $subscription = new Subscription([
            'tenant_id' => 1,
            'pppoe_username' => 'test-user',
        ]);

        $resolved = (new NetworkDeviceResolver())
            ->resolveForSubscription($subscription);

        $this->assertNotNull($resolved);
        $this->assertSame($device->id, $resolved->id);
    }

    public function test_it_returns_null_when_no_active_global_mikrotik_device_exists(): void
    {
        NetworkDevice::create([
            'tenant_id' => null,
            'name' => 'Inactive MikroTik',
            'ip_address' => '2.2.2.2',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'inactive',
        ]);

        $subscription = new Subscription([
            'tenant_id' => 1,
            'pppoe_username' => 'test-user',
        ]);

        $resolved = (new NetworkDeviceResolver())
            ->resolveForSubscription($subscription);

        $this->assertNull($resolved);
    }

    public function test_it_ignores_non_mikrotik_devices(): void
    {
        NetworkDevice::create([
            'tenant_id' => null,
            'name' => 'Other Device',
            'ip_address' => '2.2.2.2',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'other',
            'port' => 8728,
            'status' => 'active',
        ]);

        $subscription = new Subscription([
            'tenant_id' => 1,
            'pppoe_username' => 'test-user',
        ]);

        $resolved = (new NetworkDeviceResolver())
            ->resolveForSubscription($subscription);

        $this->assertNull($resolved);
    }

    public function test_it_rejects_multiple_active_global_mikrotik_devices(): void
    {
        NetworkDevice::create([
            'tenant_id' => null,
            'name' => 'MikroTik 1',
            'ip_address' => '2.2.2.2',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
        ]);

        NetworkDevice::create([
            'tenant_id' => null,
            'name' => 'MikroTik 2',
            'ip_address' => '2.2.2.3',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
        ]);

        $subscription = new Subscription([
            'tenant_id' => 1,
            'pppoe_username' => 'test-user',
        ]);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            'Multiple active global MikroTik network devices are configured.'
        );

        (new NetworkDeviceResolver())
            ->resolveForSubscription($subscription);
    }
}
