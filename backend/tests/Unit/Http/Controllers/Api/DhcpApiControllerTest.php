<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Api;

use App\Http\Controllers\Api\DhcpApiController;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\Services\DhcpServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Infrastructure\Services\NetworkManager;
use Illuminate\Http\Request;
use Tests\TestCase;

class DhcpApiControllerTest extends TestCase
{
    public function test_index_uses_network_device_repository_contract(): void
    {
        $device = new NetworkDevice();

        $repository = $this->createMock(NetworkDeviceRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with(7)
            ->willReturn($device);

        $dhcp = $this->createMock(DhcpServiceInterface::class);
        $dhcp
            ->expects($this->once())
            ->method('getAll')
            ->willReturn([
                ['address' => '192.168.88.10'],
            ]);

        $provider = $this->createMock(NetworkProviderInterface::class);
        $provider
            ->expects($this->once())
            ->method('dhcp')
            ->willReturn($dhcp);

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

        $controller = new DhcpApiController(
            $networkManager,
            $repository,
        );

        $request = Request::create(
            '/api/network/dhcp',
            'GET',
            ['device_id' => 7],
        );

        $response = $controller->index($request);

        $this->assertSame(200, $response->getStatusCode());

        $payload = $response->getData(true);

        $this->assertTrue($payload['success']);
        $this->assertSame(1, $payload['count']);
        $this->assertSame(
            ['address' => '192.168.88.10'],
            $payload['data'][0],
        );
    }

    public function test_index_aborts_when_network_device_connection_fails(): void
    {
        $device = new NetworkDevice();

        $repository = $this->createMock(NetworkDeviceRepositoryInterface::class);
        $repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with(7)
            ->willReturn($device);

        $networkManager = $this->createMock(NetworkManager::class);
        $networkManager
            ->expects($this->once())
            ->method('connect')
            ->with($device)
            ->willReturn(false);

        $controller = new DhcpApiController(
            $networkManager,
            $repository,
        );

        $request = Request::create(
            '/api/network/dhcp',
            'GET',
            ['device_id' => 7],
        );

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $this->expectExceptionMessage(
            'Unable to connect to network device.'
        );

        $controller->index($request);
    }
}
