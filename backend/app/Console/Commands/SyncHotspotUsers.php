<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Network\MikrotikService;
use App\Models\HotspotUser;
use App\Models\Customer;
use App\Models\NetworkDevice;
use Illuminate\Support\Facades\Log;

class SyncHotspotUsers extends Command
{
    protected $signature = 'mikrotik:sync-hotspot {--device= : جهاز معين}';
    protected $description = 'مزامنة مستخدمي Hotspot من MikroTik';

    protected $mikrotikService;

    protected $commands = [
        \App\Console\Commands\SyncHotspotUsers::class,
    ];

    public function __construct(MikrotikService $mikrotikService)
    {
        parent::__construct();
        $this->mikrotikService = $mikrotikService;
    }

    public function handle()
    {
        $this->info('🔄 بدء مزامنة مستخدمي Hotspot...');

        $devices = $this->getDevices();

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

                // 1. جلب المستخدمين من Hotspot
                $hotspotUsers = $this->mikrotikService->getHotspotUsers();
                $this->info("📥 تم جلب " . count($hotspotUsers) . " مستخدم Hotspot");

                // 2. حفظ المستخدمين في قاعدة البيانات
                $this->syncUsers($hotspotUsers, $device);

                // 3. جلب الجلسات النشطة وتحديثها
                $activeSessions = $this->mikrotikService->getHotspotActiveSessions();
                $this->updateActiveSessions($activeSessions, $device);

                // 4. تحديث حالة الجهاز
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

    protected function getDevices()
    {
        $query = NetworkDevice::where('status', 'active');

        if ($this->option('device')) {
            $query->where('id', $this->option('device'));
        }

        return $query->get();
    }

    protected function syncUsers($hotspotUsers, $device)
    {
        $addedCount = 0;
        $updatedCount = 0;
        $failedCount = 0;

        foreach ($hotspotUsers as $hotspotUser) {
            $username = $hotspotUser['name'];

            // تنظيف البيانات
            $profile = $hotspotUser['profile'] ?? null;
            if ($profile) {
                $profile = mb_convert_encoding($profile, 'UTF-8', 'auto');
                $profile = preg_replace('/[^\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{08A0}-\x{08FF}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}a-zA-Z0-9\s\-_]/u', '', $profile);
            }

            try {
                // التحقق من وجود المستخدم
                $existingUser = HotspotUser::where('username', $username)->first();

                if ($existingUser) {
                    // تحديث المستخدم الموجود
                    $existingUser->update([
                        'customer_id' => Customer::where('username', $username)->first()?->id,
                        'password' => $hotspotUser['password'] ?? $existingUser->password,
                        'mikrotik_device_id' => $device->id,
                        'profile' => $profile ?? $existingUser->profile,
                        'status' => $hotspotUser['disabled'] ? 'disabled' : 'active',
                        'last_sync_at' => now(),
                    ]);
                    $updatedCount++;
                    $this->line("🔄 تم تحديث المستخدم: {$username}");
                } else {
                    // إضافة مستخدم جديد
                    HotspotUser::create([
                        'username' => $username,
                        'customer_id' => Customer::where('username', $username)->first()?->id,
                        'password' => $hotspotUser['password'] ?? '********',
                        'mikrotik_device_id' => $device->id,
                        'profile' => $profile ?? null,
                        'status' => $hotspotUser['disabled'] ? 'disabled' : 'active',
                        'last_sync_at' => now(),
                    ]);
                    $addedCount++;
                    $this->info("📝 تم إضافة مستخدم Hotspot جديد: {$username}");
                }
            } catch (\Exception $e) {
                $failedCount++;
                $this->error("❌ فشل معالجة المستخدم: {$username} - " . $e->getMessage());
                \Illuminate\Support\Facades\Log::error("Hotspot Sync Error: " . $e->getMessage(), [
                    'username' => $username,
                    'profile' => $profile,
                ]);
            }
        }

        $this->info("📊 ملخص المزامنة:");
        $this->info("   ✅ تمت الإضافة: {$addedCount}");
        $this->info("   🔄 تم التحديث: {$updatedCount}");
        $this->info("   ❌ فشل: {$failedCount}");
    }

    protected function updateActiveSessions($sessions, $device)
    {

        // إضافة وقت انتهاء الجلسة
        $sessionTimeout = now()->addMinutes(5); // 5 دقائق

        HotspotUser::where('mikrotik_device_id', $device->id)
            ->whereIn('username', $activeUsernames)
            ->update([
                'is_online' => true,
                'last_login_at' => now(),
                'session_expiry' => $sessionTimeout, // إضافة عمود جديد
            ]);
        // تحديث المستخدمين المتصلين
        $activeUsernames = array_column($sessions, 'name');

        // تحديث حالة المتصلين
        HotspotUser::where('mikrotik_device_id', $device->id)
            ->whereIn('username', $activeUsernames)
            ->update([
                'is_online' => true,
                'last_login_at' => now(),
            ]);

        // تحديث بيانات الاتصال للمستخدمين المتصلين
        foreach ($sessions as $session) {
            // 🔥 تحويل uptime من نص (5m54s) إلى ثواني (integer)
            $uptimeSeconds = $this->convertUptimeToSeconds($session['uptime'] ?? '0s');

            HotspotUser::where('mikrotik_device_id', $device->id)
                ->where('username', $session['name'])
                ->update([
                    'uptime' => $uptimeSeconds,
                    'bytes_in' => $session['bytes_in'] ?? 0,
                    'bytes_out' => $session['bytes_out'] ?? 0,
                ]);
        }

        // تحديث حالة غير المتصلين
        HotspotUser::where('mikrotik_device_id', $device->id)
            ->whereNotIn('username', $activeUsernames)
            ->update([
                'is_online' => false,
            
    }

    /**
     * تحويل وقت الاتصال من نص إلى ثواني
     * مثال: "5m54s" -> 354 ثانية
     */
    protected function convertUptimeToSeconds(string $uptime): int
    {
        $seconds = 0;
        $parts = [];

        // استخراج الأرقام مع الوحدات (d, h, m, s)
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
