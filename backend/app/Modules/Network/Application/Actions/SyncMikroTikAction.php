<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use Illuminate\Support\Facades\Log;
use Throwable;

final class SyncMikroTikAction
{
    public function __construct(
        private readonly NetworkManagerInterface $networkManager,
        private readonly SyncMikroTikUsersAction $pppoeSync,
        private readonly SyncHotspotUsersAction $hotspotSync,
    ) {
    }

    public function execute(?int $deviceId = null): bool
    {
        $devices = NetworkDevice::query()
            ->where('status', 'active')
            ->when(
                $deviceId !== null,
                fn ($query) => $query->where('id', $deviceId),
            )
            ->get();

        if ($devices->isEmpty()) {
            return false;
        }

        $processed = false;

        foreach ($devices as $device) {
            try {
                if (! $this->networkManager->connect($device->id)) {
                    Log::warning(
                        'MikroTik full sync connection failed',
                        [
                            'device_id' => $device->id,
                        ],
                    );

                    $device->update([
                        'is_online' => false,
                        'last_error' => 'MikroTik connection failed.',
                    ]);

                    continue;
                }

                $this->pppoeSync->syncConnectedDevice($device);

                $this->hotspotSync->syncConnectedDevice($device);

                $runtime = $this->refreshRuntime();

                $device->update([
                    'is_online' => true,
                    'last_ping_at' => now(),
                    'last_sync_at' => now(),
                    'last_error' => null,
                    'status' => 'active',
                ]);

                Log::info(
                    'MikroTik full sync completed',
                    [
                        'device_id' => $device->id,
                        'runtime' => $runtime,
                    ],
                );

                $processed = true;
            } catch (Throwable $e) {
                Log::error(
                    'MikroTik full sync failed',
                    [
                        'device_id' => $device->id,
                        'message' => $e->getMessage(),
                    ],
                );

                $device->update([
                    'is_online' => false,
                    'last_error' => $e->getMessage(),
                ]);
            } finally {
                $this->networkManager->disconnect();
            }
        }

        return $processed;
    }

    /**
     * Refresh current RouterOS runtime resources.
     *
     * These resources are intentionally not persisted because
     * they are provider/runtime state, not business aggregates.
     *
     * Runtime read failures are logged without changing the
     * device connectivity state.
     *
     * @return array<string,int|bool>
     */
    private function refreshRuntime(): array
    {
        $provider = $this->networkManager->provider();

        if ($provider === null) {
            throw new \RuntimeException(
                'No active MikroTik provider connection.',
            );
        }

        $runtime = [
            'queue_count' => 0,
            'dhcp_lease_count' => 0,
            'firewall_rule_count' => 0,
            'nat_rule_count' => 0,
            'interface_count' => 0,
            'system_available' => false,
            'identity_available' => false,
        ];

        $resources = [
            'queue' => function () use ($provider): int {
                return count($provider->queue()->getAll());
            },
            'dhcp' => function () use ($provider): int {
                return count($provider->dhcp()->getAll());
            },
            'firewall' => function () use ($provider): int {
                return count($provider->firewall()->getRules());
            },
            'nat' => function () use ($provider): int {
                return count($provider->firewall()->getNatRules());
            },
            'interfaces' => function () use ($provider): int {
                return count($provider->monitoring()->getInterfaces());
            },
            'system' => function () use ($provider): bool {
                return ! empty(
                    $provider->monitoring()->getSystemResource()
                );
            },
            'identity' => function () use ($provider): bool {
                return ! empty(
                    $provider->monitoring()->getIdentity()
                );
            },
        ];

        foreach ($resources as $resource => $reader) {
            try {
                $value = $reader();

                $runtimeKey = match ($resource) {
                    'queue' => 'queue_count',
                    'dhcp' => 'dhcp_lease_count',
                    'firewall' => 'firewall_rule_count',
                    'nat' => 'nat_rule_count',
                    'interfaces' => 'interface_count',
                    'system' => 'system_available',
                    'identity' => 'identity_available',
                };

                $runtime[$runtimeKey] = $value;
            } catch (Throwable $e) {
                Log::warning(
                    'MikroTik runtime resource refresh failed',
                    [
                        'resource' => $resource,
                        'message' => $e->getMessage(),
                    ],
                );
            }
        }

        return $runtime;
    }
}
