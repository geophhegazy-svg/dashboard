<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Network;

use App\Models\Tenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Network\Application\Actions\ProvisionNetworkServiceAction;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\Services\DhcpServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\PppoeServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\QueueServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class ProvisionNetworkServiceActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_missing_network_device_fails_provisioning(): void
    {
        $service = $this->makeService([
            'network_device_id' => null,
        ]);

        $manager = Mockery::mock(NetworkManagerInterface::class);

        $manager->shouldNotReceive('connect');
        $manager->shouldReceive('disconnect')->once();

        $result = (new ProvisionNetworkServiceAction($manager))
            ->execute($service);

        $service->refresh();

        $this->assertFalse($result);
        $this->assertSame('failed', $service->provisioning_status);
        $this->assertSame(
            'Network device is required.',
            $service->last_error
        );
    }

    public function test_connection_failure_marks_service_failed(): void
    {
        $service = $this->makeService();

        $manager = Mockery::mock(NetworkManagerInterface::class);

        $manager
            ->shouldReceive('connect')
            ->once()
            ->with($service->network_device_id)
            ->andReturn(false);

        $manager->shouldReceive('disconnect')->once();

        $result = (new ProvisionNetworkServiceAction($manager))
            ->execute($service);

        $service->refresh();

        $this->assertFalse($result);
        $this->assertSame('failed', $service->provisioning_status);
        $this->assertSame(
            'Failed to connect to network device.',
            $service->last_error
        );
    }

    public function test_pppoe_static_service_provisions_user_queue_and_dhcp(): void
    {
        $service = $this->makeService([
            'connection_type' => 'pppoe',
            'ip_mode' => 'static',
            'ip_address' => '10.10.10.50',
            'mac_address' => 'AA:BB:CC:DD:EE:50',
        ]);

        $pppoe = Mockery::mock(PppoeServiceInterface::class);
        $queue = Mockery::mock(QueueServiceInterface::class);
        $dhcp = Mockery::mock(DhcpServiceInterface::class);

        $pppoe
            ->shouldReceive('getUser')
            ->once()
            ->with($service->username)
            ->andReturn(null);

        $pppoe
            ->shouldReceive('createUser')
            ->once()
            ->withArgs(function (
                string $username,
                string $password,
                string $profile,
                array $options
            ) use ($service): bool {
                return $username === $service->username
                    && $password === $service->password
                    && $profile === $service->package->mikrotik_profile
                    && ($options['remote_address'] ?? null)
                        === $service->ip_address;
            })
            ->andReturn(true);

        $pppoe
            ->shouldReceive('enableUser')
            ->once()
            ->with($service->username)
            ->andReturn(true);

        $queue
            ->shouldReceive('getUserQueue')
            ->once()
            ->with($service->username)
            ->andReturn(null);

        $queue
            ->shouldReceive('create')
            ->once()
            ->withArgs(function (
                string $name,
                string $target,
                string $maxLimit
            ) use ($service): bool {
                return $name === $service->username
                    && $target === $service->ip_address
                    && $maxLimit === '5M/10M';
            })
            ->andReturn(true);

        $dhcp
            ->shouldReceive('findByMac')
            ->once()
            ->with($service->mac_address)
            ->andReturn(null);

        $dhcp
            ->shouldReceive('create')
            ->once()
            ->with(
                $service->ip_address,
                $service->mac_address,
                $service->username,
                Mockery::type('array')
            )
            ->andReturn(true);

        $dhcp
            ->shouldReceive('findByMac')
            ->once()
            ->with($service->mac_address)
            ->andReturn([
                '.id' => '*10',
            ]);

        $dhcp
            ->shouldReceive('makeStatic')
            ->once()
            ->with('*10')
            ->andReturn(true);

        $provider = Mockery::mock(NetworkProviderInterface::class);

        $provider->shouldReceive('pppoe')->once()->andReturn($pppoe);
        $provider->shouldReceive('queue')->once()->andReturn($queue);
        $provider->shouldReceive('dhcp')->once()->andReturn($dhcp);

        $manager = Mockery::mock(NetworkManagerInterface::class);

        $manager
            ->shouldReceive('connect')
            ->once()
            ->with($service->network_device_id)
            ->andReturn(true);

        $manager->shouldReceive('provider')->atLeast()->once()->andReturn($provider);
        $manager->shouldReceive('disconnect')->once();

        $result = (new ProvisionNetworkServiceAction($manager))
            ->execute($service);

        $service->refresh();

        $this->assertTrue($result);
        $this->assertSame('provisioned', $service->provisioning_status);
        $this->assertNull($service->last_error);
        $this->assertNotNull($service->last_provisioned_at);
        $this->assertNotNull($service->last_sync_at);
    }

    public function test_pppoe_dynamic_service_provisions_without_queue_or_dhcp(): void
    {
        $service = $this->makeService([
            'connection_type' => 'pppoe',
            'ip_mode' => 'dynamic',
            'ip_address' => null,
            'mac_address' => null,
        ]);

        $pppoe = Mockery::mock(PppoeServiceInterface::class);
        $queue = Mockery::mock(QueueServiceInterface::class);
        $dhcp = Mockery::mock(DhcpServiceInterface::class);

        $pppoe
            ->shouldReceive('getUser')
            ->once()
            ->with($service->username)
            ->andReturn(null);

        $pppoe
            ->shouldReceive('createUser')
            ->once()
            ->andReturn(true);

        $pppoe
            ->shouldReceive('enableUser')
            ->once()
            ->with($service->username)
            ->andReturn(true);

        $queue->shouldNotReceive('getUserQueue');
        $queue->shouldNotReceive('create');
        $queue->shouldNotReceive('updateSpeed');

        $dhcp->shouldNotReceive('findByMac');
        $dhcp->shouldNotReceive('create');
        $dhcp->shouldNotReceive('makeStatic');

        $provider = Mockery::mock(NetworkProviderInterface::class);

        $provider->shouldReceive('pppoe')->once()->andReturn($pppoe);
        $provider->shouldReceive('queue')->once()->andReturn($queue);

        $manager = Mockery::mock(NetworkManagerInterface::class);

        $manager
            ->shouldReceive('connect')
            ->once()
            ->with($service->network_device_id)
            ->andReturn(true);

        $manager->shouldReceive('provider')->atLeast()->once()->andReturn($provider);
        $manager->shouldReceive('disconnect')->once();

        $result = (new ProvisionNetworkServiceAction($manager))
            ->execute($service);

        $service->refresh();

        $this->assertTrue($result);
        $this->assertSame('provisioned', $service->provisioning_status);
    }

    public function test_hotspot_service_provisions_user(): void
    {
        $service = $this->makeService([
            'connection_type' => 'hotspot',
            'ip_mode' => 'dynamic',
            'ip_address' => null,
            'mac_address' => null,
        ]);

        $hotspot = Mockery::mock(HotspotServiceInterface::class);

        $hotspot
            ->shouldReceive('findUser')
            ->once()
            ->with($service->username)
            ->andReturn(null);

        $hotspot
            ->shouldReceive('createUser')
            ->once()
            ->withArgs(function (
                string $username,
                string $password,
                string $profile
            ) use ($service): bool {
                return $username === $service->username
                    && $password === $service->password
                    && $profile === $service->package->mikrotik_profile;
            })
            ->andReturn(true);

        $hotspot
            ->shouldReceive('enableUser')
            ->once()
            ->with($service->username)
            ->andReturn(true);

        $provider = Mockery::mock(NetworkProviderInterface::class);

        $provider->shouldReceive('hotspot')->once()->andReturn($hotspot);

        $manager = Mockery::mock(NetworkManagerInterface::class);

        $manager
            ->shouldReceive('connect')
            ->once()
            ->with($service->network_device_id)
            ->andReturn(true);

        $manager->shouldReceive('provider')->atLeast()->once()->andReturn($provider);
        $manager->shouldReceive('disconnect')->once();

        $result = (new ProvisionNetworkServiceAction($manager))
            ->execute($service);

        $service->refresh();

        $this->assertTrue($result);
        $this->assertSame('provisioned', $service->provisioning_status);
    }

    public function test_provider_exception_marks_service_failed_and_records_error(): void
    {
        $service = $this->makeService();

        $manager = Mockery::mock(NetworkManagerInterface::class);
        $provider = Mockery::mock(NetworkProviderInterface::class);

        $manager
            ->shouldReceive('connect')
            ->once()
            ->with($service->network_device_id)
            ->andReturn(true);

        $manager->shouldReceive('provider')->atLeast()->once()->andReturn($provider);
        $manager->shouldReceive('disconnect')->once();

        $provider
            ->shouldReceive('pppoe')
            ->once()
            ->andThrow(new \RuntimeException('Router failure'));

        $result = (new ProvisionNetworkServiceAction($manager))
            ->execute($service);

        $service->refresh();

        $this->assertFalse($result);
        $this->assertSame('failed', $service->provisioning_status);
        $this->assertSame('Router failure', $service->last_error);
    }

    private function makeService(array $overrides = []): NetworkService
    {
        $tenant = Tenant::factory()->create();

        $customer = Customer::factory()->create([
            'tenant_id' => $tenant->id,
        ]);

        $package = Package::factory()->create([
            'tenant_id' => $tenant->id,
            'download_speed' => 10,
            'upload_speed' => 5,
            'mikrotik_profile' => '10M',
        ]);

        $device = NetworkDevice::create([
            'name' => 'Provisioning Test MikroTik',
            'ip_address' => '192.168.88.1',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => false,
        ]);

        return NetworkService::create(array_merge([
            'tenant_id' => $tenant->id,
            'customer_id' => $customer->id,
            'package_id' => $package->id,
            'network_device_id' => $device->id,
            'connection_type' => 'pppoe',
            'username' => 'provision-user-' . uniqid(),
            'password' => 'secret-password',
            'mac_address' => 'AA:BB:CC:DD:EE:50',
            'ip_address' => '10.10.10.50',
            'ip_mode' => 'static',
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'pending',
            'provisioning_status' => 'pending',
        ], $overrides));
    }
}
