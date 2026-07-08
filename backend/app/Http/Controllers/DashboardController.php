<?php

namespace App\Http\Controllers;

use App\Models\HotspotUser;
use App\Models\NetworkDevice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // إحصائيات Hotspot
        $totalUsers = HotspotUser::count();
        $activeUsers = HotspotUser::where('status', 'active')->count();
        $onlineUsers = HotspotUser::where('is_online', true)->count();

        // المستخدمين المتصلين حالياً
        $connectedUsers = HotspotUser::where('is_online', true)
            ->orderBy('uptime', 'desc')
            ->limit(10)
            ->get(['username', 'profile', 'uptime', 'bytes_in', 'bytes_out']);

        // إحصائيات الأجهزة
        $devices = NetworkDevice::all();
        $onlineDevices = NetworkDevice::where('is_online', true)->count();

        // توزيع المستخدمين حسب الباقات
        $packageStats = HotspotUser::where('is_online', true)
            ->select('profile', \DB::raw('count(*) as total'))
            ->groupBy('profile')
            ->get();

        return view('dashboard.index', compact(
            'totalUsers',
            'activeUsers',
            'onlineUsers',
            'connectedUsers',
            'devices',
            'onlineDevices',
            'packageStats'
        ));
    }
}
