<?php

declare(strict_types=1);

namespace App\Services\Network;

use App\Exceptions\RouterConnectionException;
use App\Models\NetworkDevice;

class RouterConnectionService
{
    public function __construct(
        protected MikroTikAdvancedService $mikrotik,
    ) {}

    /**
     * Connect to router using device id.
     *
     * @throws RouterConnectionException
     */
    public function connectByDeviceId(int $deviceId): NetworkDevice
    {
        $device = NetworkDevice::active()->find($deviceId);

        if (! $device) {
            throw RouterConnectionException::deviceNotFound($deviceId);
        }

        return $this->connect($device);
    }

    /**
     * Connect using NetworkDevice model.
     *
     * @throws RouterConnectionException
     */
    public function connect(NetworkDevice $device): NetworkDevice
    {
        $connected = $this->mikrotik->connect(
            $device->ip_address,
            $device->username,
            $device->password,
            $device->port ?? 8728
        );

        if (! $connected) {
            throw RouterConnectionException::connectionFailed(
                $device->name
            );
        }

        return $device;
    }

    public function service(): MikroTikAdvancedService
    {
        return $this->mikrotik;
    }
}
