<?php

declare(strict_types=1);

namespace App\Modules\Usage\Application\Actions;

use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Usage\UsageSnapshot;
use Illuminate\Support\Facades\Log;

final readonly class SyncUsageSnapshotsAction
{
    public function __construct(
        private MikrotikServiceInterface $mikrotikService,
    ) {}

    public function execute(): int
    {
        $devices = NetworkDevice::where('status', 'active')->get();

        if ($devices->isEmpty()) {
            return 0;
        }

        $now = now();
        $totalSnapshots = 0;

        foreach ($devices as $device) {
            try {
                $connected = $this->mikrotikService->connect(
                    $device->ip_address,
                    $device->username,
                    $device->password,
                    $device->port ?? 8728,
                );

                if (! $connected) {
                    continue;
                }

                $totalSnapshots += $this->syncPppoeUsage($device, $now);
                $totalSnapshots += $this->syncHotspotUsage($device, $now);
            } catch (\Exception $e) {
                Log::error(
                    'Usage Sync Error: ' . $e->getMessage(),
                );
            }
        }

        return $totalSnapshots;
    }

    private function syncPppoeUsage(
        NetworkDevice $device,
        $now,
    ): int {
        $count = 0;

        $queues = $this->mikrotikService->getQueueUsage();

        foreach ($queues as $queue) {
            $username = $queue['name'];

            if (! $username) {
                continue;
            }

            $subscription = Subscription::where(
                'pppoe_username',
                $username,
            )->first();

            if (! $subscription) {
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

    private function syncHotspotUsage(
        NetworkDevice $device,
        $now,
    ): int {
        $count = 0;

        $sessions = $this->mikrotikService
            ->getHotspotActiveSessions();

        foreach ($sessions as $session) {
            $username = $session['name'] ?? null;

            if (! $username) {
                continue;
            }

            $subscription = HotspotSubscription::where(
                'hotspot_username',
                $username,
            )->first();

            if (! $subscription) {
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
