<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Infrastructure\Services\NetworkManager;
use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use App\Modules\Dashboard\Application\Services\DashboardService;
use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Invoice\Application\Queries\GetInvoiceDashboardMetricsQuery;

class MikrotikController extends Controller
{
    public function __construct(
        protected NetworkManager $networkManager,
        protected NetworkDeviceRepositoryInterface $networkDeviceRepository,
        protected DashboardService $dashboardService,
        protected QueryDispatcher $queryDispatcher,
    ) {}



    /**
     * Health Check
     */
    public function test()
    {
        try {

            $deviceId = request()->input('device_id', 1);

            $provider = $this->provider($deviceId);


            if (!$provider) {

                return response()->json([
                    'success' => false,
                    'message' => 'Unable to connect',
                ], 503);
            }


            return response()->json([
                'success' => true,
                'message' => 'Connected successfully',
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 503);
        }
    }



    protected function provider(int $deviceId): ?NetworkProviderInterface
    {
        $device = $this->networkDeviceRepository->find($deviceId);


        if (!$device) {
            return null;
        }


        if (!$this->networkManager->connect($device)) {
            return null;
        }


        return $this->networkManager->provider();
    }




    /**
     * PPPoE Users
     */
    public function pppoeUsers()
    {
        $provider = $this->provider(
            request()->input('device_id', 1)
        );


        if (!$provider) {
            return response()->json([]);
        }


        return response()->json(
            $provider->pppoe()->getAllUsers()
        );
    }




    /**
     * Hotspot Users
     */
    public function hotspotUsers()
    {
        $provider = $this->provider(
            request()->input('device_id', 1)
        );


        if (!$provider) {
            return response()->json([]);
        }


        return response()->json(
            $provider->hotspot()->getUsers()
        );
    }





    /**
     * DHCP
     */
    public function dhcpLeases()
    {
        $provider = $this->provider(
            request()->input('device_id', 1)
        );


        if (!$provider) {
            return response()->json([]);
        }


        return response()->json(
            $provider->dhcp()->getAll()
        );
    }





    /**
     * Dashboard
     */
    public function dashboardStats()
    {
        $dashboard = $this->dashboardService->getDashboardData();

        $invoiceMetrics = $this->queryDispatcher->dispatch(
            new GetInvoiceDashboardMetricsQuery()
        );

        return response()->json([
            'customers' => $dashboard['business']['total_customers'],

            'active_pppoe' => $dashboard['subscriptions']['pppoe']['active'],

            'active_hotspot' => $dashboard['subscriptions']['hotspot']['active'],

            'pending_invoices' => $invoiceMetrics['pending_invoices'],

            'paid_invoices' => $invoiceMetrics['paid_invoices'],

            'monthly_revenue' => $invoiceMetrics['monthly_revenue'],
        ]);
    }
}
