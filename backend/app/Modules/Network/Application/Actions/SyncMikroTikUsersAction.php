<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Network\Infrastructure\Persistence\Models\PPPoEUser;
use Illuminate\Support\Facades\Log;

final class SyncMikroTikUsersAction
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

                $mikrotikUsers = $this->mikrotikService->getAllUsers();

                $this->syncUsers($mikrotikUsers, $device);

                $activeSessions = $this->mikrotikService->getActiveSessions();

                $this->updateActiveSessions($activeSessions, $device);

                $device->update([
                    'last_sync_at' => now(),
                    'status' => 'active',
                ]);
            } catch (\Throwable $e) {
                Log::error(
                    'MikroTik Sync Error',
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
        array $mikrotikUsers,
        NetworkDevice $device,
    ): void {
        foreach ($mikrotikUsers as $mikrotikUser) {
            $username = $mikrotikUser['name'] ?? null;

            if (! $username) {
                continue;
            }

            $pppoeUser = PPPoEUser::query()
                ->where('username', $username)
                ->where('mikrotik_device_id', $device->id)
                ->first();

            if ($pppoeUser) {
                $pppoeUser->update([
                    'status' => ! empty($mikrotikUser['disabled'])
                        ? 'disabled'
                        : 'active',
                    'last_sync_at' => now(),
                ]);

                continue;
            }

            PPPoEUser::create([
                'tenant_id' => $device->tenant_id,
                'username' => $username,
                'password' => $mikrotikUser['password'] ?? '********',
                'mikrotik_device_id' => $device->id,
                'profile' => $mikrotikUser['profile'] ?? null,
                'status' => ! empty($mikrotikUser['disabled'])
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

        PPPoEUser::query()
            ->where('mikrotik_device_id', $device->id)
            ->whereIn('username', $activeUsernames)
            ->update([
                'is_online' => true,
                'last_login_at' => now(),
            ]);

        PPPoEUser::query()
            ->where('mikrotik_device_id', $device->id)
            ->whereNotIn('username', $activeUsernames)
            ->update([
                'is_online' => false,
            ]);
    }
}
