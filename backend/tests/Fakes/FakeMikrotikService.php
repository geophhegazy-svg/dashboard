<?php

declare(strict_types=1);

namespace Tests\Fakes;

use App\Contracts\MikrotikServiceInterface;
use App\Models\NetworkDevice;

class FakeMikrotikService implements MikrotikServiceInterface
{
    public array $enabledUsers = [];

    public array $disabledUsers = [];

    public bool $failOnEnable = false;

    public bool $failOnDisable = false;

    public function connect(
        string $ip,
        string $username,
        string $password,
        int $port = 8728
    ): bool {
        return true;
    }

    public function createUser(
        string $username,
        string $password,
        string $profile,
        array $options = []
    ): bool {
        return true;
    }

    public function disableUser(string $username): bool
    {
        if ($this->failOnDisable) {
            throw new \RuntimeException('Fake MikroTik failure');
        }

        $this->disabledUsers[] = $username;

        return true;
    }

    public function enableUser(string $username): bool
    {
        if ($this->failOnEnable) {
            throw new \RuntimeException('Fake MikroTik failure');
        }

        $this->enabledUsers[] = $username;

        return true;
    }

    public function deleteUser(string $username): bool
    {
        return true;
    }

    public function getAllUsers(): array
    {
        return [];
    }

    public function getActiveSessions(): array
    {
        return [];
    }

    public function updateUserQueue(
        string $username,
        int $download,
        int $upload
    ): bool {
        return true;
    }

    public function getQueueUsage(): array
    {
        return [];
    }

    public function getDeviceStats(): array
    {
        return [];
    }

    public function ping(string $ip): bool
    {
        return true;
    }

    public function disconnectUser(string $username): bool
    {
        return true;
    }

    public function updateDeviceStatus(NetworkDevice $device): void
    {
        // Fake
    }

    /*
    |--------------------------------------------------------------------------
    | Hotspot
    |--------------------------------------------------------------------------
    */

    public function getHotspotUsers(): array
    {
        return [];
    }

    public function getHotspotActiveSessions(): array
    {
        return [];
    }

    public function createHotspotUser(
        string $username,
        string $password,
        string $profile,
        array $options = []
    ): bool {
        return true;
    }

    public function disableHotspotUser(string $username): bool
    {
        return true;
    }

    public function enableHotspotUser(string $username): bool
    {
        return true;
    }
}
