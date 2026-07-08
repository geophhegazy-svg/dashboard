<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HotspotUser;
use Illuminate\Support\Facades\Mail;

class SendDailyReport extends Command
{
    protected $signature = 'report:daily';
    protected $description = 'إرسال تقرير يومي عبر البريد الإلكتروني';

    public function handle()
    {
        $total = HotspotUser::count();
        $online = HotspotUser::where('is_online', true)->count();
        $active = HotspotUser::where('status', 'active')->count();

        $data = [
            'total' => $total,
            'online' => $online,
            'active' => $active,
            'date' => now()->format('Y-m-d'),
            'online_percentage' => $total > 0 ? round(($online / $total) * 100, 2) : 0,
        ];

        // إرسال البريد
        Mail::raw("تقرير يومي - EgyptNet ISP\n\n" .
                  "📊 إحصائيات اليوم: {$data['date']}\n" .
                  "👤 إجمالي المستخدمين: {$data['total']}\n" .
                  "🟢 المتصلين: {$data['online']}\n" .
                  "✅ النشطين: {$data['active']}\n" .
                  "📈 نسبة المتصلين: {$data['online_percentage']}%",
            function ($message) {
                $message->to('admin@egyptnet.com')
                        ->subject('تقرير يومي - EgyptNet ISP');
            }
        );

        $this->info('✅ تم إرسال التقرير اليومي');
        return 0;
    }
}
