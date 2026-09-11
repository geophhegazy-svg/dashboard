<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Network;

use App\Modules\Network\Application\Actions\SyncMikroTikUsersAction;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Infrastructure\Persistence\Models\PPPoEUser;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

final class SyncMikroTikUsersActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_and_syncs_pppoe_users_and_active_sessions(): void
    {
        $tenant = Tenant::factory()->create();

        $device = NetworkDevice::create([
            'tenant_id' => $tenant->id,
            'name' => 'MikroTik Test',
            'ip_address' => '192.0.2.1',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'is_online' => false,
        ]);

        $service = Mockery::mock(MikrotikServiceInterface::class);

        $service->shouldReceive('connect')
            ->once()
            ->with('192.0.2.1', 'admin', 'secret', 8728)
            ->andReturnTrue();

        $service->shouldReceive('getAllUsers')
            ->once()
            ->andReturn([
                [
                    'name' => 'pppoe001',
                    'password' => 'pass001',
                    'profile' => '5M',
                    'disabled' => false,
                ],
            ]);

        $service->shouldReceive('getActiveSessions')
            ->once()
            ->andReturn([
                [
                    'name' => 'pppoe001',
                ],
            ]);

        $action = new SyncMikroTikUsersAction($service);

        $this->assertTrue($action->execute($device->id));

        $this->assertDatabaseHas('pppoe_users', [
            'tenant_id' => $tenant->id,
            'username' => 'pppoe001',
            'mikrotik_device_id' => $device->id,
            'profile' => '5M',
            'status' => 'active',
            'is_online' => true,
        ]);

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
            'name' => 'MikroTik Failure Test',
            'ip_address' => '192.0.2.3',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
            'last_sync_at' => $lastSyncAt,
        ]);

        $user = PPPoEUser::create([
            'tenant_id' => $tenant->id,
            'username' => 'pppoe-existing',
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

        $service->shouldReceive('getAllUsers')
            ->once()
            ->andThrow(
                new \App\Exceptions\Network\QueryException(
                    'Router command execution failed.'
                )
            );

        $service->shouldNotReceive('getActiveSessions');

        $action = new SyncMikroTikUsersAction($service);

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

    public function test_it_updates_existing_pppoe_user_and_marks_missing_sessions_offline(): void
    {
        $tenant = Tenant::factory()->create();

        $device = NetworkDevice::create([
            'tenant_id' => $tenant->id,
            'name' => 'MikroTik Test',
            'ip_address' => '192.0.2.2',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
        ]);

        $onlineUser = PPPoEUser::create([
            'tenant_id' => $tenant->id,
            'username' => 'pppoe-online',
            'password' => 'old',
            'mikrotik_device_id' => $device->id,
            'profile' => '1M',
            'status' => 'active',
            'is_online' => false,
        ]);

        $offlineUser = PPPoEUser::create([
            'tenant_id' => $tenant->id,
            'username' => 'pppoe-offline',
            'password' => 'old',
            'mikrotik_device_id' => $device->id,
            'profile' => '1M',
            'status' => 'active',
            'is_online' => true,
        ]);

        $service = Mockery::mock(MikrotikServiceInterface::class);

        $service->shouldReceive('connect')->once()->andReturnTrue();

        $service->shouldReceive('getAllUsers')
            ->once()
            ->andReturn([
                [
                    'name' => 'pppoe-online',
                    'disabled' => true,
                ],
                [
                    'name' => 'pppoe-offline',
                    'disabled' => false,
                ],
            ]);

        $service->shouldReceive('getActiveSessions')
            ->once()
            ->andReturn([
                [
                    'name' => 'pppoe-online',
                ],
            ]);

        $action = new SyncMikroTikUsersAction($service);

        $this->assertTrue($action->execute($device->id));

        $onlineUser->refresh();
        $offlineUser->refresh();

        $this->assertSame('disabled', $onlineUser->status);
        $this->assertTrue($onlineUser->is_online);

        $this->assertSame('active', $offlineUser->status);
        $this->assertFalse($offlineUser->is_online);
    }
}
