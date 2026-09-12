<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Api\Network;

use App\Http\Controllers\Api\Network\FirewallController;
use App\Modules\Network\Application\Actions\CreateFirewallRuleAction;
use App\Modules\Network\Application\Actions\UpdateFirewallRuleAction;
use App\Modules\Network\Application\Actions\DeleteFirewallRuleAction;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Tests\TestCase;

class FirewallControllerTest extends TestCase
{
    public function test_index_uses_network_device_repository_contract(): void
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

        $repository
            ->expects($this->once())
            ->method('findOrFail')
            ->with(1)
            ->willReturn($device);

        $repository
            ->expects($this->once())
            ->method('active')
            ->willReturn(new Collection([$device]));

        $networkManager = $this->createMock(
            NetworkManagerInterface::class
        );

        $networkManager
            ->expects($this->once())
            ->method('connect')
            ->with(1)
            ->willReturn(false);

        $createFirewallRuleAction = new CreateFirewallRuleAction($networkManager);
        $updateFirewallRuleAction = new UpdateFirewallRuleAction($networkManager);
        $deleteFirewallRuleAction = new DeleteFirewallRuleAction($networkManager);

        $controller = new FirewallController(
            $networkManager,
            $repository,
            $createFirewallRuleAction,
            $updateFirewallRuleAction,
            $deleteFirewallRuleAction,
        );

        $request = Request::create(
            '/firewall',
            'GET',
            ['device_id' => 1]
        );

        $response = $controller->index($request);

        $this->assertSame(
            'firewall.index',
            $response->getName()
        );
    }

    public function test_create_uses_network_device_repository_contract(): void
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

        $repository
            ->expects($this->once())
            ->method('active')
            ->willReturn(new Collection([$device]));

        $networkManager = $this->createMock(
            NetworkManagerInterface::class
        );

        $createFirewallRuleAction = new CreateFirewallRuleAction($networkManager);
        $updateFirewallRuleAction = new UpdateFirewallRuleAction($networkManager);
        $deleteFirewallRuleAction = new DeleteFirewallRuleAction($networkManager);

        $controller = new FirewallController(
            $networkManager,
            $repository,
            $createFirewallRuleAction,
            $updateFirewallRuleAction,
            $deleteFirewallRuleAction,
        );

        $request = Request::create(
            '/firewall/create',
            'GET',
            ['device_id' => 1]
        );

        $response = $controller->create($request);

        $this->assertSame(
            'firewall.create',
            $response->getName()
        );
    }
}
