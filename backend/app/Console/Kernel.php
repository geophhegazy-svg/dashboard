<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SyncMikroTik::class,
        \App\Console\Commands\SyncHotspotUsers::class,
        \App\Console\Commands\PingMikroTik::class,
        \App\Console\Commands\CleanupMikroTik::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // مزامنة Hotspot كل 5 دقائق
        $schedule->command('mikrotik:sync-hotspot')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/hotspot-sync.log'));

        // مزامنة MikroTik كل 5 دقائق
        $schedule->command('mikrotik:sync')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->appendOutputTo(storage_path('logs/mikrotik-sync.log'));

        // فحص الأجهزة كل دقيقة
        $schedule->command('mikrotik:ping')
            ->everyMinute()
            ->withoutOverlapping();

        // تنظيف الجلسات القديمة كل ساعة
        $schedule->command('mikrotik:cleanup')
            ->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
