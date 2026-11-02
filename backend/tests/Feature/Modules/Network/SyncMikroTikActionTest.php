<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Network;

use App\Models\Tenant;
use App\Modules\Network\Application\Actions\SyncHotspotUsersAction;
use App\Modules\Network\Application\Actions\SyncMikroTikAction;
use App\Modules\Network\Application\Actions\SyncMikroTikUsersAction;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\Services\DhcpServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\FirewallServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\MonitoringServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\PppoeServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\QueueServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class SyncMikroTikActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_performs_full_mikrotik_sync_with_one_connection(): void
    {
        $tenant = Tenant::factory()->create();

        $device = NetworkDevice::create([
            'tenant_id' => $tenant->id,
            'name' => 'Full Sync Test',
            'ip_address' => '192.0.2.50',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => false,
        ]);

        $mikrotikService = Mockery::mock(
            MikrotikServiceInterface::class
        );

        $mikrotikService
            ->shouldReceive('getAllUsers')
            ->once()
            ->andReturn([]);

        $mikrotikService
            ->shouldReceive('getActiveSessions')
            ->once()
            ->andReturn([]);

        $mikrotikService
            ->shouldReceive('getHotspotUsers')
            ->once()
            ->andReturn([]);

        $mikrotikService
            ->shouldReceive('getHotspotActiveSessions')
            ->once()
            ->andReturn([]);

        $pppoe = Mockery::mock(PppoeServiceInterface::class);
        $queue = Mockery::mock(QueueServiceInterface::class);
        $hotspot = Mockery::mock(HotspotServiceInterface::class);
        $firewall = Mockery::mock(FirewallServiceInterface::class);
        $dhcp = Mockery::mock(DhcpServiceInterface::class);
        $monitoring = Mockery::mock(MonitoringServiceInterface::class);

        $queue
            ->shouldReceive('getAll')
            ->once()
            ->andReturn([]);

        $dhcp
            ->shouldReceive('getAll')
            ->once()
            ->andReturn([]);

        $firewall
            ->shouldReceive('getRules')
            ->once()
            ->andReturn([]);

        $firewall
            ->shouldReceive('getNatRules')
            ->once()
            ->andReturn([]);

        $monitoring
            ->shouldReceive('getInterfaces')
            ->once()
            ->andReturn([]);

        $monitoring
            ->shouldReceive('getSystemResource')
            ->once()
            ->andReturn([
                'uptime' => '1d',
            ]);

        $monitoring
            ->shouldReceive('getIdentity')
            ->once()
            ->andReturn([
                'name' => 'MikroTik-Test',
            ]);

        $provider = Mockery::mock(NetworkProviderInterface::class);

        $provider
            ->shouldReceive('queue')
            ->once()
            ->andReturn($queue);

        $provider
            ->shouldReceive('dhcp')
            ->once()
            ->andReturn($dhcp);

        $provider
            ->shouldReceive('firewall')
            ->twice()
            ->andReturn($firewall);

        $provider
            ->shouldReceive('monitoring')
            ->times(3)
            ->andReturn($monitoring);

        $manager = Mockery::mock(NetworkManagerInterface::class);

        $manager
            ->shouldReceive('connect')
            ->once()
            ->with($device->id)
            ->andReturnTrue();

        $manager
            ->shouldReceive('provider')
            ->once()
            ->andReturn($provider);

        $manager
            ->shouldReceive('disconnect')
            ->once();

        $action = new SyncMikroTikAction(
            $manager,
            new SyncMikroTikUsersAction($mikrotikService),
            new SyncHotspotUsersAction($mikrotikService),
        );

        $this->assertTrue($action->execute($device->id));

        $device->refresh();

        $this->assertTrue($device->is_online);
        $this->assertSame('active', $device->status);
        $this->assertNotNull($device->last_sync_at);
        $this->assertNull($device->last_error);
    }

    public function test_it_disconnects_when_runtime_refresh_fails(): void
    {
        $tenant = Tenant::factory()->create();

        $device = NetworkDevice::create([
            'tenant_id' => $tenant->id,
            'name' => 'Full Sync Failure Test',
            'ip_address' => '192.0.2.51',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => true,
        ]);

        $mikrotikService = Mockery::mock(
            MikrotikServiceInterface::class
        );

        $mikrotikService
            ->shouldReceive('getAllUsers')
            ->once()
            ->andReturn([]);

        $mikrotikService
            ->shouldReceive('getActiveSessions')
            ->once()
            ->andReturn([]);

        $mikrotikService
            ->shouldReceive('getHotspotUsers')
            ->once()
            ->andReturn([]);

        $mikrotikService
            ->shouldReceive('getHotspotActiveSessions')
            ->once()
            ->andReturn([]);

        $pppoe = Mockery::mock(PppoeServiceInterface::class);
        $queue = Mockery::mock(QueueServiceInterface::class);
        $hotspot = Mockery::mock(HotspotServiceInterface::class);
        $firewall = Mockery::mock(FirewallServiceInterface::class);
        $dhcp = Mockery::mock(DhcpServiceInterface::class);
        $monitoring = Mockery::mock(MonitoringServiceInterface::class);

        $queue
            ->shouldReceive('getAll')
            ->once()
            ->andThrow(
                new \RuntimeException(
                    'Router queue read failed.'
                )
            );

        $provider = Mockery::mock(NetworkProviderInterface::class);

        $provider
            ->shouldReceive('queue')
            ->once()
            ->andReturn($queue);

        $manager = Mockery::mock(NetworkManagerInterface::class);

        $manager
            ->shouldReceive('connect')
            ->once()
            ->with($device->id)
            ->andReturnTrue();

        $manager
            ->shouldReceive('provider')
            ->once()
            ->andReturn($provider);

        $manager
            ->shouldReceive('disconnect')
            ->once();

        $action = new SyncMikroTikAction(
            $manager,
            new SyncMikroTikUsersAction($mikrotikService),
            new SyncHotspotUsersAction($mikrotikService),
        );

        $this->assertTrue($action->execute($device->id));

        $device->refresh();

        $this->assertTrue($device->is_online);
        $this->assertNull($device->last_error);
    }
}
