<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NetworkDevice;

class PingMikroTik extends Command
{
    protected $signature = 'mikrotik:ping';
    protected $description = 'فحص حالة أجهزة MikroTik';

    public function handle()
    {
        $this->info('🔄 فحص أجهزة MikroTik...');

        $devices = NetworkDevice::where('status', 'active')->get();

        foreach ($devices as $device) {
            $isOnline = $this->ping($device->ip_address);

            $device->update([
                'is_online' => $isOnline,
                'last_ping_at' => now(),
                'status' => $isOnline ? 'active' : 'inactive',
            ]);

            $status = $isOnline ? '✅ Online' : '❌ Offline';
            $this->line("{$status} - {$device->name} ({$device->ip_address})");
        }

        $this->info('✅ اكتمل الفحص');
        return 0;
    }

    protected function ping($ip)
    {
        $output = shell_exec("ping -c 1 -W 1 $ip 2>/dev/null");
        return strpos($output, '1 received') !== false;
    }
}
