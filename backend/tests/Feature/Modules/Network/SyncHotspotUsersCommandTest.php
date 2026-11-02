<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Network;

use App\Models\Tenant;
use App\Modules\Network\Application\Actions\SyncHotspotUsersAction;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Presentation\Console\Commands\SyncHotspotUsersCommand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Tests\TestCase;

final class SyncHotspotUsersCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_failure_when_hotspot_sync_action_fails(): void
    {
        $device = $this->createActiveDevice();

        $service = Mockery::mock(MikrotikServiceInterface::class);

        $service->shouldReceive('connect')
            ->once()
            ->andReturnFalse();

        $command = new SyncHotspotUsersCommand(
            new SyncHotspotUsersAction($service),
        );

        $command->setLaravel($this->app);

        $input = new ArrayInput(
            ['--device' => (string) $device->id],
            $command->getDefinition(),
        );

        $exitCode = $command->run($input, new BufferedOutput());

        $this->assertSame(SyncHotspotUsersCommand::FAILURE, $exitCode);
    }

    public function test_it_returns_success_when_hotspot_sync_action_succeeds(): void
    {
        $device = $this->createActiveDevice();

        $service = Mockery::mock(MikrotikServiceInterface::class);

        $service->shouldReceive('connect')
            ->once()
            ->andReturnTrue();

        $service->shouldReceive('getHotspotUsers')
            ->once()
            ->andReturn([]);

        $service->shouldReceive('getHotspotActiveSessions')
            ->once()
            ->andReturn([]);

        $command = new SyncHotspotUsersCommand(
            new SyncHotspotUsersAction($service),
        );

        $command->setLaravel($this->app);

        $input = new ArrayInput(
            ['--device' => (string) $device->id],
            $command->getDefinition(),
        );

        $exitCode = $command->run($input, new BufferedOutput());

        $this->assertSame(SyncHotspotUsersCommand::SUCCESS, $exitCode);
    }

    private function createActiveDevice(): NetworkDevice
    {
        $tenant = Tenant::factory()->create();

        return NetworkDevice::create([
            'tenant_id' => $tenant->id,
            'name' => 'Hotspot Command Test',
            'ip_address' => '192.0.2.10',
            'username' => 'admin',
            'password' => 'secret',
            'type' => 'mikrotik',
            'port' => 8728,
            'status' => 'active',
        ]);
    }
}