<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Network\MikroTikService;
use App\Models\HotspotUser;
use App\Models\Customer;
use App\Models\NetworkDevice;
use Illuminate\Support\Facades\Log;

class SyncHotspotUsers extends Command
{
    protected $signature = 'mikrotik:sync-hotspot {--device= : جهاز معين}';
    protected $description = 'مزامنة مستخدمي Hotspot من MikroTik';

    protected $mikrotikService;

    public function __construct(MikroTikService $mikrotikService)
    {
        parent::__construct();
        $this->mikrotikService = $mikrotikService;
    }

    public function handle()
    {
        $this->info('🔄 بدء مزامنة مستخدمي Hotspot...');

        $devices = NetworkDevice::where('status', 'active')->get();

        if ($devices->isEmpty()) {
            $this->error('❌ لا توجد أجهزة MikroTik نشطة');
            return 1;
        }

        foreach ($devices as $device) {
            $this->info("📡 مزامنة Hotspot من الجهاز: {$device->name} ({$device->ip_address})");

            try {
                $connected = $this->mikrotikService->connect(
                    $device->ip_address,
                    $device->username,
                    $device->password,
                    $device->port ?? 8728
                );

                if (!$connected) {
                    $this->error("❌ فشل الاتصال بالجهاز: {$device->name}");
                    continue;
                }

                $hotspotUsers = $this->mikrotikService->getHotspotUsers();
                $this->info("📥 تم جلب " . count($hotspotUsers) . " مستخدم Hotspot");

                $this->syncUsers($hotspotUsers, $device);

                $activeSessions = $this->mikrotikService->getHotspotActiveSessions();
                $this->updateActiveSessions($activeSessions, $device);

                $device->update([
                    'last_sync_at' => now(),
                    'status' => 'active',
                ]);

                $this->info("✅ تمت مزامنة Hotspot للجهاز: {$device->name}");
            } catch (\Exception $e) {
                $this->error("❌ خطأ في مزامنة Hotspot: " . $e->getMessage());
                Log::error("Hotspot Sync Error: " . $e->getMessage());
            }
        }

        $this->info('✅ اكتملت مزامنة Hotspot بنجاح');
        return 0;
    }

    protected function syncUsers($hotspotUsers, $device)
    {
        foreach ($hotspotUsers as $hotspotUser) {
            $username = $hotspotUser['name'];

            $profile = $hotspotUser['profile'] ?? null;
            if ($profile) {
                $profile = mb_convert_encoding($profile, 'UTF-8', 'auto');
                $profile = preg_replace('/[^\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{08A0}-\x{08FF}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}a-zA-Z0-9\s\-_]/u', '', $profile);
            }

            $existingUser = HotspotUser::where('username', $username)->first();

            if ($existingUser) {
                $existingUser->update([
                    'password' => $hotspotUser['password'] ?? $existingUser->password,
                    'mikrotik_device_id' => $device->id,
                    'profile' => $profile ?? $existingUser->profile,
                    'status' => $hotspotUser['disabled'] ? 'disabled' : 'active',
                    'last_sync_at' => now(),
                ]);
                $this->line("🔄 تم تحديث المستخدم: {$username}");
            } else {
                HotspotUser::create([
                    'username' => $username,
                    'customer_id' => Customer::where('username', $username)->first()?->id,
                    'password' => $hotspotUser['password'] ?? '********',
                    'mikrotik_device_id' => $device->id,
                    'profile' => $profile ?? null,
                    'status' => $hotspotUser['disabled'] ? 'disabled' : 'active',
                    'last_sync_at' => now(),
                ]);
                $this->info("📝 تم إضافة مستخدم Hotspot جديد: {$username}");
            }
        }
    }

    protected function updateActiveSessions($sessions, $device)
    {
        $activeUsernames = array_column($sessions, 'name');

        HotspotUser::where('mikrotik_device_id', $device->id)
            ->whereIn('username', $activeUsernames)
            ->update([
                'is_online' => true,
                'last_login_at' => now(),
            ]);

        foreach ($sessions as $session) {
            $uptime = $session['uptime'] ?? '0s';
            $seconds = $this->convertUptimeToSeconds($uptime);

            HotspotUser::where('mikrotik_device_id', $device->id)
                ->where('username', $session['name'])
                ->update([
                    'uptime' => $seconds,
                    'bytes_in' => $session['bytes_in'] ?? 0,
                    'bytes_out' => $session['bytes_out'] ?? 0,
                ]);
        }

        HotspotUser::where('mikrotik_device_id', $device->id)
            ->whereNotIn('username', $activeUsernames)
            ->update([
                'is_online' => false,
            ]);
    }

    protected function convertUptimeToSeconds(string $uptime): int
    {
        $seconds = 0;
        if (preg_match_all('/(\d+)([dhms])/', $uptime, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $value = (int)$match[1];
                $unit = $match[2];
                switch ($unit) {
                    case 'd':
                        $seconds += $value * 86400;
                        break;
                    case 'h':
                        $seconds += $value * 3600;
                        break;
                    case 'm':
                        $seconds += $value * 60;
                        break;
                    case 's':
                        $seconds += $value;
                        break;
                }
            }
        }
        return $seconds;
    }
}
