<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\Api;

use App\Core\QueryBus\QueryDispatcher;
use App\Http\Controllers\Api\MikrotikController;
use App\Modules\Dashboard\Application\Services\DashboardService;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\Services\PppoeServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Infrastructure\Services\NetworkManager;
use Tests\TestCase;

class MikrotikControllerTest extends TestCase
{
    public function test_pppoe_users_uses_network_device_repository_contract(): void
    {
        $device = new NetworkDevice();

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
            NetworkManager::class
        );

        $networkManager
            ->expects($this->once())
            ->method('connect')
            ->with($device)
            ->willReturn(true);

        $networkManager
            ->expects($this->once())
            ->method('provider')
            ->willReturn($provider);

        $dashboardService = $this->createMock(
            DashboardService::class
        );

        $queryDispatcher = app(QueryDispatcher::class);

        $controller = new MikrotikController(
            $networkManager,
            $repository,
            $dashboardService,
            $queryDispatcher,
        );

        $response = $controller->pppoeUsers();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame([], $response->getData(true));
    }

    public function test_dashboard_stats_uses_dashboard_service_and_registered_invoice_query(): void
    {
        $repository = $this->createMock(
            NetworkDeviceRepositoryInterface::class
        );

        $networkManager = $this->createMock(
            NetworkManager::class
        );

        $dashboardService = $this->createMock(
            DashboardService::class
        );

        $dashboardService
            ->expects($this->once())
            ->method('getDashboardData')
            ->willReturn([
                'business' => [
                    'total_customers' => 10,
                    'packages_count' => 5,
                ],
                'subscriptions' => [
                    'pppoe' => [
                        'active' => 7,
                    ],
                    'hotspot' => [
                        'active' => 3,
                    ],
                ],
            ]);

        $invoiceRepository = $this->createMock(
            InvoiceRepositoryInterface::class
        );

        $invoiceRepository
            ->method('countByStatus')
            ->willReturnMap([
                ['pending', 2],
                ['paid', 8],
            ]);

        $invoiceRepository
            ->expects($this->once())
            ->method('sumPaidForCurrentMonth')
            ->willReturn(1500.0);

        $invoiceRepository
            ->expects($this->once())
            ->method('countAll')
            ->willReturn(10);

        $this->app->instance(
            InvoiceRepositoryInterface::class,
            $invoiceRepository
        );

        $queryDispatcher = app(QueryDispatcher::class);

        $controller = new MikrotikController(
            $networkManager,
            $repository,
            $dashboardService,
            $queryDispatcher,
        );

        $response = $controller->dashboardStats();

        $this->assertSame(200, $response->getStatusCode());

        $this->assertSame(
            [
                'customers' => 10,
                'active_pppoe' => 7,
                'active_hotspot' => 3,
                'pending_invoices' => 2,
                'paid_invoices' => 8,
                'monthly_revenue' => 1500,
            ],
            $response->getData(true)
        );
    }
}
