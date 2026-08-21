<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Network\Infrastructure\Persistence\Models\HotspotUser;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'totalUsers' => HotspotUser::count(),
            'onlineUsers' => HotspotUser::where('is_online', true)->count(),
            'activeUsers' => HotspotUser::where('status', 'active')->count(),
            'totalDevices' => NetworkDevice::count(),
            'onlineDevices' => NetworkDevice::where('is_online', true)->count(),
        ]);
    }

    public function stats()
    {
        return response()->json([
            'totalUsers' => HotspotUser::count(),
            'onlineUsers' => HotspotUser::where('is_online', true)->count(),
            'totalDevices' => NetworkDevice::count(),
            'onlineDevices' => NetworkDevice::where('is_online', true)->count(),
        ]);
    }
}
