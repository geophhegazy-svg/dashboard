<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NetworkDevice;
use App\Services\TelegramNotificationService;
use Illuminate\Support\Facades\Log;

class PingMikroTik extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mikrotik:ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'فحص حالة أجهزة MikroTik';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 فحص أجهزة MikroTik...');

        $devices = NetworkDevice::where('status', 'active')->get();

        if ($devices->isEmpty()) {
            $this->warn('⚠️ لا توجد أجهزة MikroTik نشطة');
            return 0;
        }

        $telegram = new TelegramNotificationService();

        foreach ($devices as $device) {
            $this->line("📡 فحص الجهاز: {$device->name} ({$device->ip_address})");

            $wasOnline = $device->is_online;
            $isOnline = $this->ping($device->ip_address);

            // 🔥 تحديث الحالة دون تغيير status
            $device->update([
                'is_online' => $isOnline,
                'last_ping_at' => now(),
            ]);

            $statusIcon = $isOnline ? '✅' : '❌';
            $statusText = $isOnline ? 'Online' : 'Offline';
            $this->line("{$statusIcon} {$device->name} - {$statusText}");

            if (!$isOnline && $wasOnline) {
                $this->warn("🚨 تنبيه: الجهاز {$device->name} أصبح غير متصل!");
                Log::warning("MikroTik Device Offline: {$device->name} ({$device->ip_address})");
                $telegram->sendDeviceAlert($device);
            }

            if ($isOnline && !$wasOnline) {
                $this->info("✅ الجهاز {$device->name} عاد للاتصال!");
                $telegram->sendMessage("✅ <b>الجهاز عاد للاتصال</b>\n\n📡 {$device->name}\n🌐 {$device->ip_address}\n⏰ " . now()->format('Y-m-d H:i:s'));
            }
        }

        $this->info('✅ اكتمل الفحص');
        return 0;
    }

    /**
     * فحص الاتصال بالجهاز عبر Ping
     */
    protected function ping($ip)
    {
        // محاولة ping مع مهلة 1 ثانية
        $output = shell_exec("ping -c 1 -W 1 " . escapeshellarg($ip) . " 2>/dev/null");

        // التحقق من وجود '1 received' أو '1 packets received'
        if (strpos($output, '1 received') !== false || strpos($output, '1 packets received') !== false) {
            return true;
        }

        // محاولة ping عبر TCP على port 8728 (API)
        $fp = @fsockopen($ip, 8728, $errno, $errstr, 1);
        if ($fp) {
            fclose($fp);
            return true;
        }

        return false;
    }
}
