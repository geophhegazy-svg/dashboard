<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Api;

use App\Http\Controllers\Api\FirewallApiController;
use App\Modules\Network\Domain\Contracts\Services\FirewallServiceInterface;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Infrastructure\Services\NetworkManager;
use Illuminate\Http\Request;
use Tests\TestCase;

class FirewallApiControllerTest extends TestCase
{
    public function test_index_uses_network_device_repository_contract(): void
    {
        $device = new \App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice();

        $repository = $this->createMock(
            NetworkDeviceRepositoryInterface::class
        );

        $repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with(1)
            ->willReturn($device);

        $firewall = $this->createMock(
            FirewallServiceInterface::class
        );

        $firewall
            ->expects($this->once())
            ->method('getRules')
            ->willReturn([]);

        $provider = $this->createMock(
            NetworkProviderInterface::class
        );

        $provider
            ->expects($this->once())
            ->method('firewall')
            ->willReturn($firewall);

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

        $controller = new FirewallApiController(
            $networkManager,
            $repository,
        );

        $response = $controller->index(
            Request::create('/api/network/firewall')
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
        $device = new \App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice();

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

        $controller = new FirewallApiController(
            $networkManager,
            $repository,
        );

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage(
            'Unable to connect to network device.'
        );

        $controller->index(
            Request::create('/api/network/firewall')
        );
    }
}
