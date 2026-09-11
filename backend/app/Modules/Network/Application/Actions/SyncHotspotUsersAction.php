<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\HotspotUser;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use Illuminate\Support\Facades\Log;

final class SyncHotspotUsersAction
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotikService,
    ) {
    }

    public function execute(?int $deviceId = null): bool
    {
        $devices = $this->getDevices($deviceId);

        if ($devices->isEmpty()) {
            return false;
        }

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

                $hotspotUsers = $this->mikrotikService->getHotspotUsers();

                $this->syncUsers($hotspotUsers, $device);

                $activeSessions =
                    $this->mikrotikService->getHotspotActiveSessions();

                $this->updateActiveSessions(
                    $activeSessions,
                    $device,
                );

                $device->update([
                    'last_sync_at' => now(),
                    'status' => 'active',
                ]);
            } catch (\Throwable $e) {
                Log::error(
                    'Hotspot Sync Error',
                    [
                        'device_id' => $device->id,
                        'message' => $e->getMessage(),
                    ],
                );
            }
        }

        return true;
    }

    private function getDevices(?int $deviceId)
    {
        $query = NetworkDevice::query()
            ->where('status', 'active');

        if ($deviceId !== null) {
            $query->where('id', $deviceId);
        }

        return $query->get();
    }

    private function syncUsers(
        array $hotspotUsers,
        NetworkDevice $device,
    ): void {
        foreach ($hotspotUsers as $hotspotUser) {
            $username = $hotspotUser['name'] ?? null;

            if (! $username) {
                continue;
            }

            $profile = $hotspotUser['profile'] ?? null;

            if ($profile) {
                $profile = mb_convert_encoding(
                    $profile,
                    'UTF-8',
                    'auto',
                );

                $profile = preg_replace(
                    '/[^\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{08A0}-\x{08FF}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}a-zA-Z0-9\s\-_]/u',
                    '',
                    $profile,
                );
            }

            $existingUser = HotspotUser::query()
                ->where('username', $username)
                ->first();

            if ($existingUser) {
                $existingUser->update([
                    'password' =>
                        $hotspotUser['password']
                        ?? $existingUser->password,
                    'mikrotik_device_id' => $device->id,
                    'profile' => $profile ?? $existingUser->profile,
                    'status' => ! empty($hotspotUser['disabled'])
                        ? 'disabled'
                        : 'active',
                    'last_sync_at' => now(),
                ]);

                continue;
            }

            HotspotUser::create([
                'username' => $username,
                'customer_id' =>
                    Customer::query()
                        ->where('username', $username)
                        ->first()?->id,
                'password' => $hotspotUser['password'] ?? '********',
                'mikrotik_device_id' => $device->id,
                'profile' => $profile,
                'status' => ! empty($hotspotUser['disabled'])
                    ? 'disabled'
                    : 'active',
                'last_sync_at' => now(),
            ]);
        }
    }

    private function updateActiveSessions(
        array $sessions,
        NetworkDevice $device,
    ): void {
        $activeUsernames = array_filter(
            array_column($sessions, 'name'),
        );

        HotspotUser::query()
            ->where('mikrotik_device_id', $device->id)
            ->whereIn('username', $activeUsernames)
            ->update([
                'is_online' => true,
                'last_login_at' => now(),
            ]);

        foreach ($sessions as $session) {
            $username = $session['name'] ?? null;

            if (! $username) {
                continue;
            }

            $uptime = $session['uptime'] ?? '0s';

            HotspotUser::query()
                ->where('mikrotik_device_id', $device->id)
                ->where('username', $username)
                ->update([
                    'uptime' => $this->convertUptimeToSeconds($uptime),
                    'bytes_in' => $session['bytes_in'] ?? 0,
                    'bytes_out' => $session['bytes_out'] ?? 0,
                ]);
        }

        HotspotUser::query()
            ->where('mikrotik_device_id', $device->id)
            ->whereNotIn('username', $activeUsernames)
            ->update([
                'is_online' => false,
            ]);
    }

    private function convertUptimeToSeconds(string $uptime): int
    {
        $seconds = 0;

        if (
            preg_match_all(
                '/(\d+)([dhms])/',
                $uptime,
                $matches,
                PREG_SET_ORDER,
            )
        ) {
            foreach ($matches as $match) {
                $value = (int) $match[1];

                $seconds += match ($match[2]) {
                    'd' => $value * 86400,
                    'h' => $value * 3600,
                    'm' => $value * 60,
                    's' => $value,
                    default => 0,
                };
            }
        }

        return $seconds;
    }
}
