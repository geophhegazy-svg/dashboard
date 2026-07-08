<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HotspotUser;
use Illuminate\Http\Request;

class HotspotController extends Controller
{
    public function onlineUsers()
    {
        $users = HotspotUser::where('is_online', true)
            ->select('username', 'profile', 'uptime', 'bytes_in', 'bytes_out')
            ->get();
        
        return response()->json([
            'status' => 'success',
            'count' => $users->count(),
            'data' => $users
        ]);
    }

    public function stats()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'total' => HotspotUser::count(),
                'online' => HotspotUser::where('is_online', true)->count(),
                'active' => HotspotUser::where('status', 'active')->count(),
            ]
        ]);
    }
}

