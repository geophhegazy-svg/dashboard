<?php

namespace App\Services\Notification;

use Illuminate\Support\Facades\Http;

class TelegramNotificationService
{
    protected $botToken;
    protected $chatId;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN') ?: '1234567890:ABCdefGHIjklmNOPQrstUVwxyz';
        $this->chatId = env('TELEGRAM_CHAT_ID') ?: '987654321';
    }

    public function sendMessage($message)
    {
        if (!$this->botToken || !$this->chatId) {
            \Log::warning('Telegram: Missing BOT_TOKEN or CHAT_ID');
            return false;
        }

        try {
            $response = Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
                'chat_id' => $this->chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if (!$response->successful()) {
                \Log::error('Telegram API Error: ' . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Telegram Exception: ' . $e->getMessage());
            return false;
        }
    }

    public function sendDeviceAlert($device)
    {
        $status = $device->is_online ? '🟢 ONLINE' : '🔴 OFFLINE';
        $message = "🚨 <b>تنبيه جهاز MikroTik</b>\n\n";
        $message .= "📡 <b>الجهاز:</b> {$device->name}\n";
        $message .= "🌐 <b>IP:</b> {$device->ip_address}\n";
        $message .= "📊 <b>الحالة:</b> {$status}\n";
        $message .= "⏰ <b>الوقت:</b> " . now()->format('Y-m-d H:i:s');

        return $this->sendMessage($message);
    }
}
