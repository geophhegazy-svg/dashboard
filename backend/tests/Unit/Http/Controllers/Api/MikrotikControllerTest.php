<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Api;

use App\Http\Controllers\Api\MikrotikController;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\Services\PppoeServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use Tests\TestCase;

class MikrotikControllerTest extends TestCase
{
    public function test_pppoe_users_uses_network_device_repository_contract(): void
    {
        $device = new NetworkDevice();
        $device->id = 1;

        $repository = $this->createMock(
            NetworkDeviceRepositoryInterface::class
        );

        $repository
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($device);

        $pppoe = $this->createMock(
            PppoeServiceInterface::class
        );

        $pppoe
            ->expects($this->once())
            ->method('getAllUsers')
            ->willReturn([]);

        $provider = $this->createMock(
            NetworkProviderInterface::class
        );

        $provider
            ->expects($this->once())
            ->method('pppoe')
            ->willReturn($pppoe);

        $networkManager = $this->createMock(
            NetworkManagerInterface::class
        );

        $networkManager
            ->expects($this->once())
            ->method('connect')
            ->with(1)
            ->willReturn(true);

        $networkManager
            ->expects($this->once())
            ->method('provider')
            ->willReturn($provider);
        $controller = new MikrotikController(
            $networkManager,
            $repository,        );

        $response = $controller->pppoeUsers();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([], $response->getData(true));
    }


}
