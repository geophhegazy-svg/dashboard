<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PPPoEUser;
use App\Models\HotspotUser;

class CleanupMikroTik extends Command
{
    protected $signature = 'mikrotik:cleanup';
    protected $description = 'تنظيف الجلسات القديمة';

    public function handle()
    {
        $this->info('🧹 بدء تنظيف الجلسات القديمة...');

        // حذف المستخدمين الذين لم يتصلوا منذ 30 يوم
        $count = PPPoEUser::where('last_login_at', '<', now()->subDays(30))
            ->where('is_online', false)
            ->delete();

        $count += HotspotUser::where('last_login_at', '<', now()->subDays(30))
            ->where('is_online', false)
            ->delete();

        $this->info("✅ تم حذف {$count} جلسة قديمة");
        return 0;
    }
}
