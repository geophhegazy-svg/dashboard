<?php

declare(strict_types=1);

namespace App\Modules\Network\Application;

use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;


class MikrotikServiceAdapter implements MikrotikServiceInterface
{
    public function __construct(
        protected NetworkManager $networkManager
    ) {}

    protected function provider(): \App\Modules\Network\Domain\Contracts\NetworkProviderInterface
    {
        $provider = $this->networkManager->provider();

        if ($provider === null) {
            throw new \RuntimeException(
                'No active network provider connection.'
            );
        }

        return $provider;
    }

    public function connect(
        string $ip,
        string $username,
        string $password,
        int $port = 8728
    ): bool {

        $device = new NetworkDevice([
            'ip_address' => $ip,
            'username' => $username,
            'password' => $password,
            'type' => 'mikrotik',
            'port' => $port,
        ]);

        return $this->networkManager->connect($device);
    }



    public function createUser(
        string $username,
        string $password,
        string $profile,
        array $options = []
    ): bool {

        return $this->provider()
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

        return $this->provider()
            ->pppoe()
            ->disableUser($username);
    }



    public function enableUser(
        string $username
    ): bool {

        return $this->provider()
            ->pppoe()
            ->enableUser($username);
    }



    public function deleteUser(
        string $username
    ): bool {

        return $this->provider()
            ->pppoe()
            ->deleteUser($username);
    }



    public function getAllUsers(): array
    {
        return $this->provider()
            ->pppoe()
            ->getAllUsers();
    }



    public function getActiveSessions(): array
    {
        return $this->provider()
            ->pppoe()
            ->getActiveSessions();
    }



    public function updateUserQueue(
        string $username,
        int $download,
        int $upload
    ): bool {

        return $this->provider()
            ->queue()
            ->updateSpeed(
                $username,
                $download . 'M',
                $upload . 'M'
            );
    }



    public function getQueueUsage(): array
    {
        $queues = $this->provider()
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
        return $this->provider()
            ->monitoring()
            ->getSystemResource();
    }



    public function ping(
        string $ip
    ): bool {

        return $this->provider()
            ->monitoring()
            ->ping($ip);
    }



    public function disconnectUser(
        string $username
    ): bool {

        return $this->provider()
            ->pppoe()
            ->disconnectUser($username);
    }




    public function getHotspotUsers(): array
    {
        return $this->provider()
            ->hotspot()
            ->getUsers();
    }



    public function getHotspotActiveSessions(): array
    {
        return $this->provider()
            ->hotspot()
            ->getActiveSessions();
    }



    public function createHotspotUser(
        string $username,
        string $password,
        string $profile,
        array $options = []
    ): bool {

        return $this->provider()
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

        return $this->provider()
            ->hotspot()
            ->disableUser($username);
    }



    public function enableHotspotUser(
        string $username
    ): bool {

        return $this->provider()
            ->hotspot()
            ->enableUser($username);
    }
}
