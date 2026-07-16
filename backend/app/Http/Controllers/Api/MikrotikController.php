<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Contracts\Network\NetworkProviderInterface;
use App\Services\Network\NetworkManager;
use App\Models\Customer;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Models\HotspotSubscription;
use App\Models\Invoice;
use App\Models\NetworkDevice;

class MikrotikController extends Controller
{
    public function __construct(
        protected NetworkManager $networkManager
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
        $device = NetworkDevice::find($deviceId);


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
        return response()->json([

            'customers' => Customer::count(),

            'active_pppoe' => Subscription::where(
                'status',
                'active'
            )->count(),

            'active_hotspot' => HotspotSubscription::where(
                'status',
                'active'
            )->count(),

            'pending_invoices' => Invoice::where(
                'status',
                'pending'
            )->count(),

            'paid_invoices' => Invoice::where(
                'status',
                'paid'
            )->count(),

            'monthly_revenue' => Invoice::where(
                'status',
                'paid'
            )
                ->whereMonth(
                    'paid_at',
                    now()->month
                )
                ->sum('amount'),
        ]);
    }
}
