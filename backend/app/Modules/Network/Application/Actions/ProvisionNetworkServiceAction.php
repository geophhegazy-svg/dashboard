<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Actions;

use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;
use Illuminate\Support\Facades\Log;
use Throwable;

final class ProvisionNetworkServiceAction
{
    public function __construct(
        private readonly NetworkManagerInterface $networkManager,
    ) {}

    public function execute(NetworkService $service): bool
    {
        $service->update([
            'provisioning_status' => 'provisioning',
            'last_error' => null,
        ]);

        try {
            if ($service->network_device_id === null) {
                return $this->fail($service, 'Network device is required.');
            }

            if (!$this->networkManager->connect($service->network_device_id)) {
                return $this->fail($service, 'Failed to connect to network device.');
            }

            $provider = $this->networkManager->provider();

            if ($provider === null) {
                return $this->fail($service, 'Network provider is unavailable.');
            }

            $package = $service->package;

            if ($package === null) {
                return $this->fail($service, 'Package is required.');
            }

            $profile = $package->mikrotik_profile ?? 'default';

            if ($service->connection_type === 'pppoe') {
                if (!$this->provisionPppoe($service, $profile)) {
                    return $this->fail($service, 'PPPoE provisioning failed.');
                }

                if (!$this->provisionQueue($service, $package)) {
                    return $this->fail($service, 'Queue provisioning failed.');
                }
            } elseif ($service->connection_type === 'hotspot') {
                if (!$this->provisionHotspot($service, $profile)) {
                    return $this->fail($service, 'HotSpot provisioning failed.');
                }
            } else {
                return $this->fail(
                    $service,
                    'Unsupported connection type: ' . $service->connection_type
                );
            }

            if (
                $service->ip_mode === 'static'
                && $service->ip_address !== null
                && $service->mac_address !== null
            ) {
                if (!$this->provisionStaticDhcp($service)) {
                    return $this->fail($service, 'Static DHCP provisioning failed.');
                }
            }

            $service->update([
                'provisioning_status' => 'provisioned',
                'last_provisioned_at' => now(),
                'last_sync_at' => now(),
                'last_error' => null,
            ]);

            return true;
        } catch (Throwable $e) {
            Log::error('Network service provisioning failed', [
                'network_service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return $this->fail($service, $e->getMessage());
        } finally {
            $this->networkManager->disconnect();
        }
    }

    private function provisionPppoe(
        NetworkService $service,
        string $profile
    ): bool {
        $pppoe = $this->networkManager->provider()?->pppoe();

        if ($pppoe === null) {
            return false;
        }

        $existing = $pppoe->getUser($service->username);

        if ($existing !== null) {
            $updated = $pppoe->updateUser(
                $service->username,
                [
                    'password' => $service->password,
                    'profile' => $profile,
                ]
            );

            if (!$updated) {
                return false;
            }

            return $pppoe->enableUser($service->username);
        }

        $created = $pppoe->createUser(
            $service->username,
            (string) $service->password,
            $profile,
            [
                'comment' => 'EgyptNet NetworkService #' . $service->id,
                ...($service->ip_address !== null
                    ? ['remote_address' => $service->ip_address]
                    : []),
            ]
        );

        if (!$created) {
            return false;
        }

        return $pppoe->enableUser($service->username);
    }

    private function provisionQueue(
        NetworkService $service,
        object $package
    ): bool {
        $queue = $this->networkManager->provider()?->queue();

        if ($queue === null) {
            return false;
        }

        if ($service->ip_address === null) {
            return true;
        }

        $download = $package->download_speed . 'M';
        $upload = $package->upload_speed . 'M';

        $existing = $queue->getUserQueue($service->username);

        if ($existing !== null) {
            return $queue->updateSpeed(
                $service->username,
                $download,
                $upload
            );
        }

        return $queue->create(
            $service->username,
            $service->ip_address,
            "{$upload}/{$download}",
            null,
            1,
            [
                'comment' => 'EgyptNet NetworkService #' . $service->id,
            ]
        );
    }

    private function provisionHotspot(
        NetworkService $service,
        string $profile
    ): bool {
        $hotspot = $this->networkManager->provider()?->hotspot();

        if ($hotspot === null) {
            return false;
        }

        $existing = $hotspot->findUser($service->username);

        if ($existing !== null) {
            $updated = $hotspot->updateUser(
                $service->username,
                [
                    'password' => $service->password,
                    'profile' => $profile,
                ]
            );

            if (!$updated) {
                return false;
            }

            return $hotspot->enableUser($service->username);
        }

        $created = $hotspot->createUser(
            $service->username,
            (string) $service->password,
            $profile,
            [
                'comment' => 'EgyptNet NetworkService #' . $service->id,
            ]
        );

        if (!$created) {
            return false;
        }

        return $hotspot->enableUser($service->username);
    }

    private function provisionStaticDhcp(
        NetworkService $service
    ): bool {
        $dhcp = $this->networkManager->provider()?->dhcp();

        if ($dhcp === null) {
            return false;
        }

        $existing = $dhcp->findByMac($service->mac_address);

        if ($existing !== null) {
            $id = $existing['.id']
                ?? $existing['id']
                ?? null;

            if ($id === null) {
                return false;
            }

            if (!$dhcp->update(
                (string) $id,
                [
                    'address' => $service->ip_address,
                    'mac_address' => $service->mac_address,
                    'hostname' => $service->username,
                ]
            )) {
                return false;
            }

            return $dhcp->makeStatic((string) $id);
        }

        if (!$dhcp->create(
            $service->ip_address,
            $service->mac_address,
            $service->username,
            [
                'comment' => 'EgyptNet NetworkService #' . $service->id,
            ]
        )) {
            return false;
        }

        $lease = $dhcp->findByMac($service->mac_address);

        if ($lease === null) {
            return false;
        }

        $id = $lease['.id']
            ?? $lease['id']
            ?? null;

        return $id !== null
            && $dhcp->makeStatic((string) $id);
    }

    private function fail(
        NetworkService $service,
        string $error
    ): bool {
        $service->update([
            'provisioning_status' => 'failed',
            'last_error' => $error,
        ]);

        return false;
    }
}
