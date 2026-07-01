<?php

declare(strict_types=1);

namespace Tests\Fakes;

use App\Contracts\MikrotikServiceInterface;
use RouterOS\Query;

class FakeMikrotikService implements MikrotikServiceInterface
{
    public array $enabledUsers = [];

    public array $disabledUsers = [];

    public function enablePppoe(string $username): bool
    {
        $this->enabledUsers[] = $username;

        return true;
    }

    public function disablePppoe(string $username): bool
    {
        $this->disabledUsers[] = $username;

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | Unused Methods
    |--------------------------------------------------------------------------
    */

    public function getPppoeUsers(): array
    {
        return [];
    }

    public function createPppoe(
        string $username,
        string $password,
        string $profile = 'default'
    ) {
        return [];
    }

    public function findPppoe(string $username)
    {
        return null;
    }

    public function deletePppoe(string $username): bool
    {
        return true;
    }

    public function getHotspotUsers(): array
    {
        return [];
    }

    public function getActiveHotspotUsers(): array
    {
        return [];
    }

    public function createHotspot(
        string $username,
        string $password,
        string $profile = 'default'
    ) {
        return [];
    }

    public function findHotspot(string $username)
    {
        return null;
    }

    public function deleteHotspot(string $username): bool
    {
        return true;
    }

    public function enableHotspot(string $username): bool
    {
        return true;
    }

    public function disableHotspot(string $username): bool
    {
        return true;
    }

    public function getDhcpLeases(): array
    {
        return [];
    }

    public function run(Query $query): array
    {
        return [];
    }

    public function raw(string $command): array
    {
        return [];
    }
}
