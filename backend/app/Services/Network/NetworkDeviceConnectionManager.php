<?php

declare(strict_types=1);

namespace App\Services\Network;

use App\Models\NetworkDevice;
use App\Services\Network\Providers\MikroTik\MikroTikConnectionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class NetworkDeviceConnectionManager
{
    public function __construct(
        protected MikroTikConnectionService $connectionService,
    ) {}

    public function connectById(int $deviceId): MikroTikConnectionService
    {
        $device = NetworkDevice::query()->find($deviceId);

        if (! $device) {
            throw new ModelNotFoundException(
                "Network device [{$deviceId}] not found."
            );
        }

        if ($device->status !== 'active') {
            throw new RuntimeException(
                "Network device [{$device->name}] is not active."
            );
        }

        $this->connectionService->connect(
            host: $device->ip_address,
            username: $device->username,
            password: $device->password,
            port: $device->port ?? 8728,
        );

        return $this->connectionService;
    }

    public function connect(NetworkDevice $device): MikroTikConnectionService
    {
        if ($device->status !== 'active') {
            throw new RuntimeException(
                "Network device [{$device->name}] is not active."
            );
        }

        $this->connectionService->connect(
            host: $device->ip_address,
            username: $device->username,
            password: $device->password,
            port: $device->port ?? 8728,
        );

        return $this->connectionService;
    }
}
