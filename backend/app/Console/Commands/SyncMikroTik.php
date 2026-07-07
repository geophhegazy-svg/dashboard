<?php
// backend/app/Console/Commands/SyncMikroTik.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Network\MikroTikService;  // 🔥 تغيير الـ Namespace
use App\Models\Customer;
use App\Models\PPPoEUser;
use App\Models\NetworkDevice;
use Illuminate\Support\Facades\Log;

class SyncMikroTik extends Command
{
    protected $signature = 'mikrotik:sync {--device= : جهاز معين} {--auto : تشغيل تلقائي}';
    protected $description = 'مزامنة مستخدمي PPPoE بين النظام و MikroTik';

    protected $mikrotikService;

    public function __construct(MikroTikService $mikrotikService)
    {
        parent::__construct();
        $this->mikrotikService = $mikrotikService;
    }

    public function handle()
    {
        $this->info('🔄 بدء مزامنة MikroTik...');

        // جلب الأجهزة النشطة
        $devices = $this->getDevices();

        if ($devices->isEmpty()) {
            $this->error('❌ لا توجد أجهزة MikroTik نشطة');
            return 1;
        }

        foreach ($devices as $device) {
            $this->info("📡 مزامنة الجهاز: {$device->name} ({$device->ip_address})");

            try {
                // الاتصال بالجهاز
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

                // جلب المستخدمين من MikroTik
                $mikrotikUsers = $this->mikrotikService->getAllUsers();
                $this->info("📥 تم جلب " . count($mikrotikUsers) . " مستخدم من MikroTik");

                // مزامنة المستخدمين
                $this->syncUsers($mikrotikUsers, $device);

                // جلب الجلسات النشطة
                $activeSessions = $this->mikrotikService->getActiveSessions();
                $this->updateActiveSessions($activeSessions, $device);

                // تحديث حالة الجهاز
                $device->update([
                    'last_sync_at' => now(),
                    'status' => 'active',
                ]);

                $this->info("✅ تمت مزامنة الجهاز: {$device->name}");
            } catch (\Exception $e) {
                $this->error("❌ خطأ في مزامنة {$device->name}: " . $e->getMessage());
                Log::error("MikroTik Sync Error: " . $e->getMessage());
            }
        }

        $this->info('✅ اكتملت المزامنة بنجاح');
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

    protected function syncUsers($mikrotikUsers, $device)
    {
        foreach ($mikrotikUsers as $mikrotikUser) {
            // البحث عن المستخدم في النظام
            $pppoeUser = PPPoEUser::where('username', $mikrotikUser['name'])
                ->where('mikrotik_device_id', $device->id)
                ->first();

            if ($pppoeUser) {
                // تحديث المستخدم الموجود
                $pppoeUser->update([
                    'status' => $mikrotikUser['disabled'] ? 'disabled' : 'active',
                    'last_sync_at' => now(),
                ]);
            } else {
                // 🔥 إنشاء مستخدم PPPoE جديد بدون ربط بعميل
                PPPoEUser::create([
                    'username' => $mikrotikUser['name'],
                    'password' => $mikrotikUser['password'] ?? '********',
                    'mikrotik_device_id' => $device->id,
                    'profile' => $mikrotikUser['profile'] ?? null,
                    'status' => $mikrotikUser['disabled'] ? 'disabled' : 'active',
                    'last_sync_at' => now(),
                ]);

                $this->info("📝 تم إضافة مستخدم جديد: {$mikrotikUser['name']}");
            }
        }
    }

    protected function updateActiveSessions($sessions, $device)
    {
        // تحديث حالة المستخدمين المتصلين
        $activeUsernames = array_column($sessions, 'name');

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
