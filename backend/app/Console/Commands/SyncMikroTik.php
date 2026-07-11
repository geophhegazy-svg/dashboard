<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contracts\MikrotikServiceInterface;
use App\Models\Customer;
use App\Models\PPPoEUser;
use App\Models\NetworkDevice;
use Illuminate\Support\Facades\Log;

class SyncMikroTik extends Command
{
    protected $signature = 'mikrotik:sync {--device= : جهاز معين} {--auto : تشغيل تلقائي}';

    protected $description = 'مزامنة مستخدمي PPPoE بين النظام و MikroTik';

    protected MikrotikServiceInterface $mikrotikService;

    public function __construct(
        MikrotikServiceInterface $mikrotikService
    ) {
        parent::__construct();

        $this->mikrotikService = $mikrotikService;
    }

    public function handle()
    {
        $this->info('🔄 بدء مزامنة MikroTik...');

        $devices = $this->getDevices();

        if ($devices->isEmpty()) {
            $this->error('❌ لا توجد أجهزة MikroTik نشطة');

            return self::FAILURE;
        }

        foreach ($devices as $device) {

            $this->info(
                "📡 مزامنة الجهاز: {$device->name} ({$device->ip_address})"
            );

            try {

                $connected = $this->mikrotikService->connect(
                    $device->ip_address,
                    $device->username,
                    $device->password,
                    $device->port ?? 8728
                );

                if (! $connected) {

                    $this->error(
                        "❌ فشل الاتصال بالجهاز: {$device->name}"
                    );

                    continue;
                }

                $mikrotikUsers = $this->mikrotikService->getAllUsers();

                $this->info(
                    '📥 تم جلب '.count($mikrotikUsers).' مستخدم من MikroTik'
                );

                $this->syncUsers(
                    $mikrotikUsers,
                    $device
                );

                $activeSessions =
                    $this->mikrotikService->getActiveSessions();

                $this->updateActiveSessions(
                    $activeSessions,
                    $device
                );

                $device->update([
                    'last_sync_at' => now(),
                    'status'       => 'active',
                ]);

                $this->info(
                    "✅ تمت مزامنة الجهاز: {$device->name}"
                );

            } catch (\Throwable $e) {

                $this->error(
                    "❌ خطأ في مزامنة {$device->name}: ".$e->getMessage()
                );

                Log::error(
                    'MikroTik Sync Error',
                    [
                        'device_id' => $device->id,
                        'message'   => $e->getMessage(),
                    ]
                );
            }
        }

        $this->info('✅ اكتملت المزامنة بنجاح');

        return self::SUCCESS;
    }

    protected function getDevices()
    {
        $query = NetworkDevice::where('status', 'active');

        if ($this->option('device')) {

            $query->where(
                'id',
                $this->option('device')
            );
        }

        return $query->get();
    }

    /**
     * مزامنة مستخدمي PPPoE.
     */
    protected function syncUsers(
        array $mikrotikUsers,
        NetworkDevice $device
    ): void {

        foreach ($mikrotikUsers as $mikrotikUser) {

            $username = $mikrotikUser['name'] ?? null;

            if (! $username) {
                continue;
            }

            $pppoeUser = PPPoEUser::query()
                ->where('username', $username)
                ->where('mikrotik_device_id', $device->id)
                ->first();

            if ($pppoeUser) {

                $pppoeUser->update([
                    'status' => ! empty($mikrotikUser['disabled'])
                        ? 'disabled'
                        : 'active',

                    'last_sync_at' => now(),
                ]);

                continue;
            }

            PPPoEUser::create([
                'tenant_id' => $device->tenant_id,

                'username' => $username,

                'password' =>
                $mikrotikUser['password']
                    ?? '********',

                'mikrotik_device_id' => $device->id,

                'profile' =>
                $mikrotikUser['profile']
                    ?? null,

                'status' =>
                ! empty($mikrotikUser['disabled'])
                    ? 'disabled'
                    : 'active',

                'last_sync_at' => now(),
            ]);

            $this->info(
                "📝 تم إضافة مستخدم جديد: {$username}"
            );
        }
    }

    /**
     * تحديث الجلسات النشطة.
     */
    protected function updateActiveSessions(
        array $sessions,
        NetworkDevice $device
    ): void {

        $activeUsernames = array_filter(
            array_column($sessions, 'name')
        );

        PPPoEUser::query()
            ->where('mikrotik_device_id', $device->id)
            ->whereIn('username', $activeUsernames)
            ->update([
                'is_online' => true,
                'last_login_at' => now(),
            ]);

        PPPoEUser::query()
            ->where('mikrotik_device_id', $device->id)
            ->whereNotIn('username', $activeUsernames)
            ->update([
                'is_online' => false,
            ]);
    }
}
