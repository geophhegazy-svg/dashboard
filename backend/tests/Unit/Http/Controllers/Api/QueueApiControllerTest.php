<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Api;

use App\Http\Controllers\Api\QueueApiController;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\Services\QueueServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Infrastructure\Services\NetworkManager;
use Illuminate\Http\Request;
use Tests\TestCase;

class QueueApiControllerTest extends TestCase
{
    public function test_index_uses_network_device_repository_contract(): void
    {
        $device = new NetworkDevice();

        $repository = $this->createMock(
            NetworkDeviceRepositoryInterface::class
        );

        $repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with(1)
            ->willReturn($device);

        $queue = $this->createMock(
            QueueServiceInterface::class
        );

        $queue
            ->expects($this->once())
            ->method('getAll')
            ->willReturn([]);

        $provider = $this->createMock(
            NetworkProviderInterface::class
        );

        $provider
            ->expects($this->once())
            ->method('queue')
            ->willReturn($queue);

        $networkManager = $this->createMock(NetworkManager::class);

        $networkManager
            ->expects($this->once())
            ->method('connect')
            ->with($device)
            ->willReturn(true);

        $networkManager
            ->expects($this->once())
            ->method('provider')
            ->willReturn($provider);

        $controller = new QueueApiController(
            $networkManager,
            $repository,
        );

        $response = $controller->index(
            Request::create('/api/network/queue')
        );

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(
            [
                'success' => true,
                'count' => 0,
                'data' => [],
            ],
            $response->getData(true)
        );
    }

    public function test_index_aborts_when_network_device_connection_fails(): void
    {
        $device = new NetworkDevice();

        $repository = $this->createMock(
            NetworkDeviceRepositoryInterface::class
        );

        $repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with(1)
            ->willReturn($device);

        $networkManager = $this->createMock(NetworkManager::class);

        $networkManager
            ->expects($this->once())
            ->method('connect')
            ->with($device)
            ->willReturn(false);

        $controller = new QueueApiController(
            $networkManager,
            $repository,
        );

        $this->expectException(
            \Symfony\Component\HttpKernel\Exception\HttpException::class
        );

        $this->expectExceptionMessage(
            'Unable to connect to network device.'
        );

        $controller->index(
            Request::create('/api/network/queue')
        );
    }
}
