<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NetworkDevice;
use App\Services\Notification\TelegramNotificationService;
use Illuminate\Support\Facades\Log;

class PingMikroTik extends Command
{
    protected $signature = 'mikrotik:ping';
    protected $description = 'فحص حالة أجهزة MikroTik وإرسال تنبيهات';

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

            // 🔥 حفظ الحالة السابقة قبل التحديث
            $wasOnline = $device->is_online;
            $isOnline = $this->ping($device->ip_address);

            // تحديث الحالة في قاعدة البيانات
            $device->update([
                'is_online' => $isOnline,
                'last_ping_at' => now(),
            ]);

            $statusIcon = $isOnline ? '✅' : '❌';
            $statusText = $isOnline ? 'Online' : 'Offline';
            $this->line("{$statusIcon} {$device->name} - {$statusText}");

            // 🔴 تنبيه الانقطاع (Offline)
            if (!$isOnline && $wasOnline) {
                $this->warn("🚨 تنبيه: الجهاز {$device->name} أصبح غير متصل!");
                Log::warning("MikroTik Device Offline: {$device->name} ({$device->ip_address})");
                
                $message = "🚨 <b>تنبيه انقطاع الجهاز</b>\n\n";
                $message .= "📡 <b>الجهاز:</b> {$device->name}\n";
                $message .= "🌐 <b>IP:</b> {$device->ip_address}\n";
                $message .= "📊 <b>الحالة:</b> 🔴 OFFLINE\n";
                $message .= "⏰ <b>الوقت:</b> " . now()->format('Y-m-d H:i:s');
                $telegram->sendMessage($message);
                
                $this->info("📨 تم إرسال تنبيه الانقطاع");
            }

            // 🟢 تنبيه العودة (Online)
            if ($isOnline && !$wasOnline) {
                $this->info("✅ الجهاز {$device->name} عاد للاتصال!");
                
                $message = "✅ <b>تنبيه عودة الجهاز</b>\n\n";
                $message .= "📡 <b>الجهاز:</b> {$device->name}\n";
                $message .= "🌐 <b>IP:</b> {$device->ip_address}\n";
                $message .= "📊 <b>الحالة:</b> 🟢 ONLINE\n";
                $message .= "⏰ <b>الوقت:</b> " . now()->format('Y-m-d H:i:s');
                $telegram->sendMessage($message);
                
                $this->info("📨 تم إرسال تنبيه العودة");
            }

            // ⚠️ تنبيه استمرار الانقطاع (كل 5 دقائق)
            if (!$isOnline && !$wasOnline) {
                $this->warn("⚠️ الجهاز {$device->name} لا يزال غير متصل!");

                if ($device->last_ping_at && $device->last_ping_at->diffInMinutes(now()) > 5) {
                    $message = "⚠️ <b>تنبيه استمرار الانقطاع</b>\n\n";
                    $message .= "📡 <b>الجهاز:</b> {$device->name}\n";
                    $message .= "🌐 <b>IP:</b> {$device->ip_address}\n";
                    $message .= "📊 <b>الحالة:</b> 🔴 OFFLINE (مستمر)\n";
                    $message .= "⏰ <b>الوقت:</b> " . now()->format('Y-m-d H:i:s');
                    $telegram->sendMessage($message);
                    
                    $this->info("📨 تم إرسال تنبيه استمرار الانقطاع");
                }
            }

            // 🟢 تأكيد الاتصال (كل 10 دقائق)
            if ($isOnline && $wasOnline) {
                if ($device->last_ping_at && $device->last_ping_at->diffInMinutes(now()) > 10) {
                    $message = "🟢 <b>تأكيد اتصال الجهاز</b>\n\n";
                    $message .= "📡 <b>الجهاز:</b> {$device->name}\n";
                    $message .= "🌐 <b>IP:</b> {$device->ip_address}\n";
                    $message .= "📊 <b>الحالة:</b> 🟢 ONLINE\n";
                    $message .= "⏰ <b>الوقت:</b> " . now()->format('Y-m-d H:i:s');
                    $telegram->sendMessage($message);
                    
                    $this->info("📨 تم إرسال تأكيد الاتصال");
                }
            }
        }

        $this->info('✅ اكتمل الفحص');
        return 0;
    }

    protected function ping($ip)
    {
        $output = shell_exec("ping -c 1 -W 1 " . escapeshellarg($ip) . " 2>/dev/null");
        if (strpos($output, '1 received') !== false || strpos($output, '1 packets received') !== false) {
            return true;
        }
        
        $fp = @fsockopen($ip, 8728, $errno, $errstr, 1);
        if ($fp) {
            fclose($fp);
            return true;
        }
        
        return false;
    }
}
