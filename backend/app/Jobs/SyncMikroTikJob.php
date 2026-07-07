<?php
// backend/app/Jobs/SyncMikroTikJob.php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\MikroTikService;
use App\Models\NetworkDevice;
use App\Models\PPPoEUser;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class SyncMikroTikJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $deviceId;

    public function __construct($deviceId = null)
    {
        $this->deviceId = $deviceId;
    }

    public function handle(MikroTikService $mikrotikService)
    {
        $devices = $this->getDevices();

        foreach ($devices as $device) {
            try {
                // الاتصال بالجهاز
                $mikrotikService->connect(
                    $device->ip_address,
                    $device->username,
                    $device->password,
                    $device->port
                );

                // جلب المستخدمين من MikroTik
                $mikrotikUsers = $mikrotikService->getAllUsers();

                // مزامنة المستخدمين
                foreach ($mikrotikUsers as $user) {
                    $this->syncUser($user, $device);
                }

                // تحديث الجلسات النشطة
                $activeSessions = $mikrotikService->getActiveSessions();
                $this->updateSessions($activeSessions, $device);

                // تحديث حالة الجهاز
                $device->update([
                    'last_sync_at' => now(),
                    'status' => 'active',
                ]);
            } catch (\Exception $e) {
                Log::error("MikroTik Sync Job Error (Device: {$device->name}): " . $e->getMessage());

                $device->update([
                    'status' => 'inactive',
                    'last_error' => $e->getMessage(),
                ]);
            }
        }
    }

    protected function getDevices()
    {
        $query = NetworkDevice::where('status', 'active');

        if ($this->deviceId) {
            $query->where('id', $this->deviceId);
        }

        return $query->get();
    }

    protected function syncUser($mikrotikUser, $device)
    {
        $pppoeUser = PPPoEUser::where('username', $mikrotikUser['name'])
            ->where('mikrotik_device_id', $device->id)
            ->first();

        if ($pppoeUser) {
            // تحديث الحالة
            $pppoeUser->update([
                'status' => $mikrotikUser['disabled'] ? 'disabled' : 'active',
                'profile' => $mikrotikUser['profile'] ?? $pppoeUser->profile,
                'last_sync_at' => now(),
            ]);

            // تحديث حالة العميل المرتبط
            if ($pppoeUser->customer_id) {
                Customer::where('id', $pppoeUser->customer_id)->update([
                    'status' => $mikrotikUser['disabled'] ? 'suspended' : 'active',
                ]);
            }
        }
    }

    protected function updateSessions($sessions, $device)
    {
        $activeUsernames = array_column($sessions, 'name');

        // تحديث المستخدمين المتصلين
        PPPoEUser::where('mikrotik_device_id', $device->id)
            ->whereIn('username', $activeUsernames)
            ->update([
                'is_online' => true,
                'last_login_at' => now(),
            ]);

        PPPoEUser::where('mikrotik_device_id', $device->id)
            ->whereNotIn('username', $activeUsernames)
            ->update([
                'is_online' => false,
            ]);
    }
}
