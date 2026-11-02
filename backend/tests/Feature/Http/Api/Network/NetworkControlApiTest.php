<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Api\Network;

use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\Services\QueueServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\DhcpServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class NetworkControlApiTest extends TestCase
{
    use RefreshDatabase;

    private NetworkDevice $device;

    private Tenant $tenant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenant = Tenant::factory()->create();

        $this->device = NetworkDevice::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'API Test MikroTik',
            'ip_address' => '127.0.0.1',
            'username' => 'test',
            'password' => 'test',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => true,
        ]);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_network_control_routes_are_registered(): void
    {
        $routes = collect(app('router')->getRoutes())
            ->map(
                fn ($route): string => $route->methods()[0] . ' ' . $route->uri()
            );

        $expected = [
            'GET api/network/queues',
            'POST api/network/queues',
            'GET api/network/queues/usage',
            'GET api/network/queues/{name}',
            'PUT api/network/queues/{name}',
            'DELETE api/network/queues/{name}',
            'PATCH api/network/queues/{name}/toggle',
            'POST api/network/queues/{name}/reset-counters',
            'GET api/network/queues/{name}/statistics',

            'GET api/network/dhcp',
            'POST api/network/dhcp',
            'GET api/network/dhcp/statistics',
            'GET api/network/dhcp/{id}',
            'PUT api/network/dhcp/{id}',
            'DELETE api/network/dhcp/{id}',
            'PATCH api/network/dhcp/{id}/make-static',
            'PATCH api/network/dhcp/{id}/remove-static',

            'GET api/network/firewall',
            'POST api/network/firewall',
            'GET api/network/firewall/statistics',
            'GET api/network/firewall/{comment}',
            'PUT api/network/firewall/{comment}',
            'DELETE api/network/firewall/{comment}',
            'PATCH api/network/firewall/{comment}/toggle',

            'GET api/network/firewall/nat',
            'POST api/network/firewall/nat',
            'GET api/network/firewall/nat/{comment}',
            'PUT api/network/firewall/nat/{comment}',
            'DELETE api/network/firewall/nat/{comment}',
        ];

        foreach ($expected as $route) {
            $this->assertContains($route, $routes->all(), $route);
        }
    }

    public function test_queue_api_requires_queue_view_permission(): void
    {
        $user = $this->createUserWithPermissions([]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/queues?device_id=' . $this->device->id)
            ->assertForbidden();
    }

    public function test_dhcp_api_requires_dhcp_view_permission(): void
    {
        $user = $this->createUserWithPermissions([]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/dhcp?device_id=' . $this->device->id)
            ->assertForbidden();
    }

    public function test_firewall_api_requires_firewall_view_permission(): void
    {
        $user = $this->createUserWithPermissions([]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/firewall?device_id=' . $this->device->id)
            ->assertForbidden();
    }

    public function test_queue_api_rejects_missing_device_id(): void
    {
        $user = $this->createUserWithPermissions([
            'queue.view',
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/queues')
            ->assertStatus(422)
            ->assertJsonValidationErrors(['device_id']);
    }

    public function test_dhcp_api_rejects_missing_device_id(): void
    {
        $user = $this->createUserWithPermissions([
            'dhcp.view',
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/dhcp')
            ->assertStatus(422)
            ->assertJsonValidationErrors(['device_id']);
    }

    public function test_firewall_api_rejects_missing_device_id(): void
    {
        $user = $this->createUserWithPermissions([
            'firewall.view',
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/firewall')
            ->assertStatus(422)
            ->assertJsonValidationErrors(['device_id']);
    }

    public function test_queue_api_requires_existing_active_device(): void
    {
        $user = $this->createUserWithPermissions([
            'queue.view',
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/queues?device_id=999999')
            ->assertNotFound();
    }

    public function test_dhcp_api_requires_existing_active_device(): void
    {
        $user = $this->createUserWithPermissions([
            'dhcp.view',
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/dhcp?device_id=999999')
            ->assertNotFound();
    }

    public function test_firewall_api_requires_existing_active_device(): void
    {
        $user = $this->createUserWithPermissions([
            'firewall.view',
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/firewall?device_id=999999')
            ->assertNotFound();
    }


    public function test_dhcp_api_resolves_display_name_from_lease_comment_then_hotspot_mac(): void
    {
        $user = $this->createUserWithPermissions(['dhcp.view']);

        $dhcpService = Mockery::mock(DhcpServiceInterface::class);
        $dhcpService->shouldReceive('getAll')->once()->andReturn([
            [
                'address' => '192.0.2.20',
                'mac-address' => 'AA:BB:CC:DD:EE:01',
                'comment' => 'Lease name',
                'hostname' => 'client-01',
            ],
            [
                'address' => '192.0.2.21',
                'mac-address' => 'aa-bb-cc-dd-ee-02',
                'comment' => ' ',
                'hostname' => 'client-02',
            ],
            [
                'address' => '192.0.2.22',
                'mac-address' => 'AA:BB:CC:DD:EE:03',
                'comment' => '',
                'hostname' => 'client-03',
            ],
        ]);

        $hotspotService = Mockery::mock(HotspotServiceInterface::class);
        $hotspotService->shouldReceive('getUsers')->once()->andReturn([
            [
                'mac-address' => 'AA:BB:CC:DD:EE:01',
                'comment' => 'Hotspot name must not override lease comment',
            ],
            [
                'mac-address' => 'AA:BB:CC:DD:EE:02',
                'comment' => 'Hotspot customer',
            ],
            [
                'mac-address' => 'AA:BB:CC:DD:EE:03',
                'comment' => '   ',
            ],
        ]);

        $provider = Mockery::mock(NetworkProviderInterface::class);
        $provider->shouldReceive('dhcp')->once()->andReturn($dhcpService);
        $provider->shouldReceive('hotspot')->once()->andReturn($hotspotService);

        $networkManager = Mockery::mock(NetworkManagerInterface::class);
        $networkManager->shouldReceive('connect')
            ->once()
            ->with($this->device->id)
            ->andReturn(true);
        $networkManager->shouldReceive('provider')->once()->andReturn($provider);

        $this->app->instance(NetworkManagerInterface::class, $networkManager);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/dhcp?device_id=' . $this->device->id)
            ->assertOk()
            ->assertJsonPath('data.0.display_name', 'Lease name')
            ->assertJsonPath('data.1.display_name', 'Hotspot customer')
            ->assertJsonPath('data.2.display_name', null)
            ->assertJsonPath('data.2.hostname', 'client-03');
    }
    public function test_dhcp_api_returns_leases_when_hotspot_lookup_fails(): void
    {
        $user = $this->createUserWithPermissions(['dhcp.view']);

        $dhcpService = Mockery::mock(DhcpServiceInterface::class);
        $dhcpService->shouldReceive('getAll')->once()->andReturn([
            [
                'address' => '192.0.2.30',
                'mac-address' => 'AA:BB:CC:DD:EE:30',
                'comment' => '',
                'hostname' => 'client-30',
            ],
        ]);

        $hotspotService = Mockery::mock(HotspotServiceInterface::class);
        $hotspotService->shouldReceive('getUsers')
            ->once()
            ->andThrow(new \RuntimeException('Hotspot lookup failed'));

        $provider = Mockery::mock(NetworkProviderInterface::class);
        $provider->shouldReceive('dhcp')->once()->andReturn($dhcpService);
        $provider->shouldReceive('hotspot')->once()->andReturn($hotspotService);

        $networkManager = Mockery::mock(NetworkManagerInterface::class);
        $networkManager->shouldReceive('connect')
            ->once()
            ->with($this->device->id)
            ->andReturn(true);
        $networkManager->shouldReceive('provider')->once()->andReturn($provider);

        $this->app->instance(NetworkManagerInterface::class, $networkManager);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/network/dhcp?device_id=' . $this->device->id)
            ->assertOk()
            ->assertJsonPath('data.0.address', '192.0.2.30')
            ->assertJsonPath('data.0.display_name', null)
            ->assertJsonPath('data.0.hostname', 'client-30');
    }
    public function test_dhcp_api_create_passes_lease_fields_to_dhcp_service(): void
    {
        $user = $this->createUserWithPermissions(['dhcp.create']);
        $dhcpService = Mockery::mock(DhcpServiceInterface::class);

        $dhcpService->shouldReceive('create')
            ->once()
            ->with(
                '192.0.2.20',
                'AA:BB:CC:DD:EE:FF',
                'printer-01',
                ['comment' => 'Office printer'],
            )
            ->andReturn(true);

        $provider = Mockery::mock(NetworkProviderInterface::class);
        $provider->shouldReceive('dhcp')->once()->andReturn($dhcpService);

        $networkManager = Mockery::mock(NetworkManagerInterface::class);
        $networkManager->shouldReceive('connect')
            ->once()
            ->with($this->device->id)
            ->andReturn(true);
        $networkManager->shouldReceive('provider')->once()->andReturn($provider);

        $this->app->instance(NetworkManagerInterface::class, $networkManager);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/network/dhcp', [
                'device_id' => $this->device->id,
                'address' => '192.0.2.20',
                'mac_address' => 'AA:BB:CC:DD:EE:FF',
                'hostname' => 'printer-01',
                'options' => ['comment' => 'Office printer'],
            ])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'DHCP lease created.',
            ]);
    }

    public function test_dhcp_api_update_passes_nested_data_to_dhcp_service(): void
    {
        $user = $this->createUserWithPermissions(['dhcp.update']);
        $dhcpService = Mockery::mock(DhcpServiceInterface::class);

        $dhcpService->shouldReceive('update')
            ->once()
            ->with('*1', [
                'address' => '192.0.2.21',
                'mac_address' => 'AA:BB:CC:DD:EE:FF',
                'hostname' => 'printer-01',
                'comment' => 'Office printer',
            ])
            ->andReturn(true);

        $provider = Mockery::mock(NetworkProviderInterface::class);
        $provider->shouldReceive('dhcp')->once()->andReturn($dhcpService);

        $networkManager = Mockery::mock(NetworkManagerInterface::class);
        $networkManager->shouldReceive('connect')
            ->once()
            ->with($this->device->id)
            ->andReturn(true);
        $networkManager->shouldReceive('provider')->once()->andReturn($provider);

        $this->app->instance(NetworkManagerInterface::class, $networkManager);

        $this->actingAs($user, 'sanctum')
            ->putJson('/api/network/dhcp/*1', [
                'device_id' => $this->device->id,
                'data' => [
                    'address' => '192.0.2.21',
                    'mac_address' => 'AA:BB:CC:DD:EE:FF',
                    'hostname' => 'printer-01',
                    'comment' => 'Office printer',
                ],
            ])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'DHCP lease updated.',
            ]);
    }

    public function test_queue_api_create_passes_comment_options_to_queue_service(): void
    {
        $user = $this->createUserWithPermissions(['queue.create']);
        $this->actingAs($user, 'sanctum');

        $queueService = Mockery::mock(QueueServiceInterface::class);
        $queueService->shouldReceive('create')
            ->once()
            ->with(
                'contract-test-queue',
                '192.0.2.10/32',
                '10M/10M',
                '5M/5M',
                3,
                ['comment' => 'Created by contract test'],
            )
            ->andReturn(true);

        $provider = Mockery::mock(NetworkProviderInterface::class);
        $provider->shouldReceive('queue')
            ->once()
            ->andReturn($queueService);

        $networkManager = Mockery::mock(NetworkManagerInterface::class);
        $networkManager->shouldReceive('connect')
            ->once()
            ->with($this->device->id)
            ->andReturn(true);
        $networkManager->shouldReceive('provider')
            ->once()
            ->andReturn($provider);

        $this->app->instance(NetworkManagerInterface::class, $networkManager);

        $this->postJson('/api/network/queues', [
            'device_id' => $this->device->id,
            'name' => 'contract-test-queue',
            'target' => '192.0.2.10/32',
            'max_limit' => '10M/10M',
            'limit_at' => '5M/5M',
            'priority' => 3,
            'options' => [
                'comment' => 'Created by contract test',
            ],
        ])->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Queue created.',
            ]);
    }

    public function test_queue_api_update_passes_nested_data_to_queue_service(): void
    {
        $user = $this->createUserWithPermissions(['queue.update']);
        $this->actingAs($user, 'sanctum');

        $expectedData = [
            'max_limit' => '20M/20M',
            'limit_at' => '10M/10M',
            'priority' => 2,
            'comment' => 'Updated by contract test',
        ];

        $queueService = Mockery::mock(QueueServiceInterface::class);
        $queueService->shouldReceive('update')
            ->once()
            ->with('contract-test-queue', $expectedData)
            ->andReturn(true);

        $provider = Mockery::mock(NetworkProviderInterface::class);
        $provider->shouldReceive('queue')
            ->once()
            ->andReturn($queueService);

        $networkManager = Mockery::mock(NetworkManagerInterface::class);
        $networkManager->shouldReceive('connect')
            ->once()
            ->with($this->device->id)
            ->andReturn(true);
        $networkManager->shouldReceive('provider')
            ->once()
            ->andReturn($provider);

        $this->app->instance(NetworkManagerInterface::class, $networkManager);

        $this->putJson('/api/network/queues/contract-test-queue', [
            'device_id' => $this->device->id,
            'data' => $expectedData,
        ])->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Queue updated.',
            ]);
    }

    private function createUserWithPermissions(array $permissions)
    {
        $user = \App\Models\User::factory()->create([
            'tenant_id' => $this->tenant->id,
        ]);

        foreach ($permissions as $permission) {
            $user->givePermissionTo($permission);
        }

        return $user;
    }
}
