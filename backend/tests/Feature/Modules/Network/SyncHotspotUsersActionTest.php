<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Network;

use App\Models\Tenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Network\Application\Actions\SyncHotspotUsersAction;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\HotspotUser;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class SyncHotspotUsersActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_and_syncs_hotspot_users_and_active_sessions(): void
    {
        $tenant = Tenant::factory()->create();

        $device = NetworkDevice::create([
            'tenant_id' => $tenant->id,
            'name' => 'Hotspot Test',
            'ip_address' => '192.0.2.10',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
        ]);

        $customer = Customer::factory()->create([
            'tenant_id' => $tenant->id,
            'username' => 'hotspot001',
            'name' => 'Hotspot Customer',
        ]);

        $service = Mockery::mock(MikrotikServiceInterface::class);

        $service->shouldReceive('connect')
            ->once()
            ->with('192.0.2.10', 'admin', 'secret', 8728)
            ->andReturnTrue();

        $service->shouldReceive('getHotspotUsers')
            ->once()
            ->andReturn([
                [
                    'name' => 'hotspot001',
                    'password' => 'pass001',
                    'profile' => '5M',
                    'disabled' => false,
                ],
            ]);

        $service->shouldReceive('getHotspotActiveSessions')
            ->once()
            ->andReturn([
                [
                    'name' => 'hotspot001',
                    'uptime' => '1h30m10s',
                    'bytes_in' => 1000,
                    'bytes_out' => 2000,
                ],
            ]);

        $action = new SyncHotspotUsersAction($service);

        $this->assertTrue($action->execute($device->id));

        $user = HotspotUser::query()
            ->where('username', 'hotspot001')
            ->first();

        $this->assertNotNull($user);
        $this->assertSame($customer->id, $user->customer_id);
        $this->assertSame($device->id, $user->mikrotik_device_id);
        $this->assertSame('5M', $user->profile);
        $this->assertSame('active', $user->status);
        $this->assertTrue($user->is_online);
        $this->assertSame(5410, $user->uptime);
        $this->assertSame(1000, $user->bytes_in);
        $this->assertSame(2000, $user->bytes_out);

        $device->refresh();

        $this->assertNotNull($device->last_sync_at);
        $this->assertSame('active', $device->status);
    }

    public function test_it_does_not_mark_users_offline_when_router_read_fails(): void
    {
        $tenant = Tenant::factory()->create();

        $lastSyncAt = now()->subHour();

        $device = NetworkDevice::create([
            'tenant_id' => $tenant->id,
            'name' => 'Hotspot Failure Test',
            'ip_address' => '192.0.2.12',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'last_sync_at' => $lastSyncAt,
        ]);

        $user = HotspotUser::create([
            'tenant_id' => $tenant->id,
            'username' => 'hotspot-existing',
            'password' => 'secret',
            'mikrotik_device_id' => $device->id,
            'profile' => '5M',
            'status' => 'active',
            'is_online' => true,
            'last_sync_at' => $lastSyncAt,
        ]);

        $service = Mockery::mock(MikrotikServiceInterface::class);

        $service->shouldReceive('connect')
            ->once()
            ->andReturnTrue();

        $service->shouldReceive('getHotspotUsers')
            ->once()
            ->andThrow(
                new \App\Exceptions\Network\QueryException(
                    'Router command execution failed.'
                )
            );

        $service->shouldNotReceive('getHotspotActiveSessions');

        $action = new SyncHotspotUsersAction($service);

        $this->assertTrue($action->execute($device->id));

        $user->refresh();
        $device->refresh();

        $this->assertTrue($user->is_online);
        $this->assertEquals(
            $lastSyncAt->timestamp,
            $user->last_sync_at->timestamp
        );

        $this->assertEquals(
            $lastSyncAt->timestamp,
            $device->last_sync_at->timestamp
        );
    }

    public function test_it_updates_existing_hotspot_users_and_marks_missing_sessions_offline(): void
    {
        $tenant = Tenant::factory()->create();

        $device = NetworkDevice::create([
            'tenant_id' => $tenant->id,
            'name' => 'Hotspot Test',
            'ip_address' => '192.0.2.11',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
        ]);

        $onlineUser = HotspotUser::create([
            'tenant_id' => $tenant->id,
            'username' => 'hotspot-online',
            'password' => 'old',
            'mikrotik_device_id' => $device->id,
            'profile' => '1M',
            'status' => 'active',
            'is_online' => false,
        ]);

        $offlineUser = HotspotUser::create([
            'tenant_id' => $tenant->id,
            'username' => 'hotspot-offline',
            'password' => 'old',
            'mikrotik_device_id' => $device->id,
            'profile' => '1M',
            'status' => 'active',
            'is_online' => true,
        ]);

        $service = Mockery::mock(MikrotikServiceInterface::class);

        $service->shouldReceive('connect')->once()->andReturnTrue();

        $service->shouldReceive('getHotspotUsers')
            ->once()
            ->andReturn([
                [
                    'name' => 'hotspot-online',
                    'password' => 'new',
                    'profile' => '5M',
                    'disabled' => true,
                ],
                [
                    'name' => 'hotspot-offline',
                    'disabled' => false,
                ],
            ]);

        $service->shouldReceive('getHotspotActiveSessions')
            ->once()
            ->andReturn([
                [
                    'name' => 'hotspot-online',
                    'uptime' => '2m',
                    'bytes_in' => 300,
                    'bytes_out' => 400,
                ],
            ]);

        $action = new SyncHotspotUsersAction($service);

        $this->assertTrue($action->execute($device->id));

        $onlineUser->refresh();
        $offlineUser->refresh();

        $this->assertSame('disabled', $onlineUser->status);
        $this->assertSame('new', $onlineUser->password);
        $this->assertSame('5M', $onlineUser->profile);
        $this->assertTrue($onlineUser->is_online);
        $this->assertSame(120, $onlineUser->uptime);
        $this->assertSame(300, $onlineUser->bytes_in);
        $this->assertSame(400, $onlineUser->bytes_out);

        $this->assertSame('active', $offlineUser->status);
        $this->assertFalse($offlineUser->is_online);
    }
}
