<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\HotspotSubscription;
use App\Models\Invoice;
use App\Services\MikrotikService;

class MikrotikController extends Controller
{
    protected MikrotikService $mikrotik;

    public function __construct(MikrotikService $mikrotik)
    {
        $this->mikrotik = $mikrotik;
    }

    /*
    |--------------------------------------------------------------------------
    | PPPoE
    |--------------------------------------------------------------------------
    */

    public function pppoeUsers()
    {
        return response()->json(
            $this->mikrotik->getPppoeUsers()
        );
    }

    public function createPppoeUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'profile'  => 'required',
        ]);

        $this->mikrotik->createPppoe(
            $request->username,
            $request->password,
            $request->profile
        );

        return response()->json([
            'message' => 'PPPoE user created successfully'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Hotspot
    |--------------------------------------------------------------------------
    */

    public function hotspotUsers()
    {
        $users = $this->mikrotik->getHotspotUsers();

        return response()->json([
            'success' => true,
            'count'   => count($users),
            'data'    => $users,
        ]);
    }

    public function activeUsers()
    {
        return response()->json(
            $this->mikrotik->getActiveHotspotUsers()
        );
    }

    public function createHotspotUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'profile'  => 'nullable',
        ]);

        $this->mikrotik->createHotspot(
            $request->username,
            $request->password,
            $request->profile ?? 'default'
        );

        return response()->json([
            'message' => 'Hotspot user created'
        ]);
    }

    public function deleteHotspotUser($username)
    {
        if (!$this->mikrotik->deleteHotspot($username)) {

            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'User deleted'
        ]);
    }

    public function suspendHotspotUser($username)
    {
        if (!$this->mikrotik->disableHotspot($username)) {

            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Hotspot user suspended'
        ]);
    }

    public function activateHotspotUser($username)
    {
        if (!$this->mikrotik->enableHotspot($username)) {

            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Hotspot user activated'
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DHCP
    |--------------------------------------------------------------------------
    */

    public function dhcpLeases()
    {
        return response()->json(
            $this->mikrotik->getDhcpLeases()
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
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
                ->whereMonth('paid_at', now()->month)
                ->sum('amount'),
        ]);
    }
}
