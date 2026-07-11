<?php

declare(strict_types=1);

namespace App\Services\Network;

use App\Contracts\MikrotikServiceInterface;
use App\Models\NetworkDevice;
use App\Services\Network\Providers\MikroTik\MikroTikProvider;

class MikrotikServiceAdapter implements MikrotikServiceInterface
{
    public function __construct(
        protected MikroTikProvider $provider
    ) {}



    public function connect(
        string $ip,
        string $username,
        string $password,
        int $port = 8728
    ): bool {

        return $this->provider->connect(
            $ip,
            $username,
            $password,
            $port
        );
    }



    public function createUser(
        string $username,
        string $password,
        string $profile,
        array $options = []
    ): bool {

        return $this->provider
            ->pppoe()
            ->createUser(
                $username,
                $password,
                $profile,
                $options
            );
    }



    public function disableUser(
        string $username
    ): bool {

        return $this->provider
            ->pppoe()
            ->disableUser($username);
    }



    public function enableUser(
        string $username
    ): bool {

        return $this->provider
            ->pppoe()
            ->enableUser($username);
    }



    public function deleteUser(
        string $username
    ): bool {

        return $this->provider
            ->pppoe()
            ->deleteUser($username);
    }



    public function getAllUsers(): array
    {
        return $this->provider
            ->pppoe()
            ->getAllUsers();
    }



    public function getActiveSessions(): array
    {
        return $this->provider
            ->pppoe()
            ->getActiveSessions();
    }



    public function updateUserQueue(
        string $username,
        int $download,
        int $upload
    ): bool {

        return $this->provider
            ->queue()
            ->updateSpeed(
                $username,
                $download . 'M',
                $upload . 'M'
            );
    }



    public function getQueueUsage(): array
    {
        $queues = $this->provider
            ->queue()
            ->getUsage();


        return array_map(
            function (array $queue) {

                return [
                    'name' =>
                    $queue['name'] ?? null,

                    'bytes_download' =>
                    $queue['bytes_in'] ?? 0,

                    'bytes_upload' =>
                    $queue['bytes_out'] ?? 0,
                ];
            },
            $queues
        );
    }



    public function getDeviceStats(): array
    {
        return $this->provider
            ->monitoring()
            ->getSystemResource();
    }



    public function ping(
        string $ip
    ): bool {

        return $this->provider
            ->monitoring()
            ->ping($ip);
    }



    public function disconnectUser(
        string $username
    ): bool {

        return $this->provider
            ->pppoe()
            ->disconnectUser($username);
    }



    public function updateDeviceStatus(
        NetworkDevice $device
    ): void {

        $device->update([
            'status' =>
            $this->provider->isConnected()
                ? 'online'
                : 'offline',
        ]);
    }



    public function getHotspotUsers(): array
    {
        return $this->provider
            ->hotspot()
            ->getUsers();
    }



    public function getHotspotActiveSessions(): array
    {
        return $this->provider
            ->hotspot()
            ->getActiveSessions();
    }



    public function createHotspotUser(
        string $username,
        string $password,
        string $profile,
        array $options = []
    ): bool {

        return $this->provider
            ->hotspot()
            ->createUser(
                $username,
                $password,
                $profile,
                $options
            );
    }



    public function disableHotspotUser(
        string $username
    ): bool {

        return $this->provider
            ->hotspot()
            ->disableUser($username);
    }



    public function enableHotspotUser(
        string $username
    ): bool {

        return $this->provider
            ->hotspot()
            ->enableUser($username);
    }
}
