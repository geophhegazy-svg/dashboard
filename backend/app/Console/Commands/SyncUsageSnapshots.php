<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Network\MikrotikService;
use App\Models\NetworkDevice;
use App\Models\Subscription;
use App\Models\HotspotSubscription;
use App\Models\UsageSnapshot;
use Illuminate\Support\Facades\Log;

class SyncUsageSnapshots extends Command
{
    protected $signature = 'usage:sync';
    protected $description = 'أخذ لقطة دورية من استهلاك كل عملاء PPPoE و Hotspot من كل الأجهزة النشطة';

    protected $mikrotikService;

    public function __construct(MikrotikService $mikrotikService)
    {
        parent::__construct();
        $this->mikrotikService = $mikrotikService;
    }

    public function handle()
    {
        $this->info('🔄 بدء مزامنة الاستهلاك...');

        $devices = NetworkDevice::where('status', 'active')->get();

        if ($devices->isEmpty()) {
            $this->error('❌ لا توجد أجهزة MikroTik نشطة');
            return 1;
        }

        $now = now();
        $totalSnapshots = 0;

        foreach ($devices as $device) {

            $this->info("📡 مزامنة استهلاك الجهاز: {$device->name}");

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

                $totalSnapshots += $this->syncPppoeUsage($device, $now);
                $totalSnapshots += $this->syncHotspotUsage($device, $now);
            } catch (\Exception $e) {
                $this->error("❌ خطأ في مزامنة الاستهلاك: " . $e->getMessage());
                Log::error("Usage Sync Error: " . $e->getMessage());
            }
        }

        $this->info("✅ تم تسجيل {$totalSnapshots} لقطة استهلاك بنجاح");
        return 0;
    }

    /**
     * تسجيل لقطات استهلاك عملاء PPPoE (من الـ Simple Queue على الجهاز).
     */
    protected function syncPppoeUsage(NetworkDevice $device, $now): int
    {
        $count = 0;

        $queues = $this->mikrotikService->getQueueUsage();

        foreach ($queues as $queue) {

            $username = $queue['name'];

            if (!$username) {
                continue;
            }

            $subscription = Subscription::where('pppoe_username', $username)->first();

            if (!$subscription) {
                // Queue على الراوتر مش متربطة بأي اشتراك عندنا، تجاهلها
                continue;
            }

            UsageSnapshot::create([
                'tenant_id' => $device->tenant_id,
                'customer_id' => $subscription->customer_id,
                'connection_type' => 'pppoe',
                'username' => $username,
                'bytes_download' => $queue['bytes_download'],
                'bytes_upload' => $queue['bytes_upload'],
                'recorded_at' => $now,
            ]);

            $count++;
        }

        return $count;
    }

    /**
     * تسجيل لقطات استهلاك عملاء Hotspot المتصلين حاليًا (من الجلسات النشطة).
     */
    protected function syncHotspotUsage(NetworkDevice $device, $now): int
    {
        $count = 0;

        $sessions = $this->mikrotikService->getHotspotActiveSessions();

        foreach ($sessions as $session) {

            $username = $session['name'];

            if (!$username) {
                continue;
            }

            $subscription = HotspotSubscription::where('hotspot_username', $username)->first();

            if (!$subscription) {
                continue;
            }

            UsageSnapshot::create([
                'tenant_id' => $device->tenant_id,
                'customer_id' => $subscription->customer_id,
                'connection_type' => 'hotspot',
                'username' => $username,
                'bytes_download' => $session['bytes_in'],
                'bytes_upload' => $session['bytes_out'],
                'recorded_at' => $now,
            ]);

            $count++;
        }

        return $count;
    }
}
