<?php

declare(strict_types=1);

namespace App\Contracts;

use RouterOS\Query;

interface MikrotikServiceInterface
{
    /*
    |--------------------------------------------------------------------------
    | PPPoE
    |--------------------------------------------------------------------------
    */

    public function getPppoeUsers(): array;

    public function createPppoe(
        string $username,
        string $password,
        string $profile = 'default'
    );

    public function findPppoe(string $username);

    public function deletePppoe(string $username): bool;

    public function enablePppoe(string $username): bool;

    public function disablePppoe(string $username): bool;

    /*
    |--------------------------------------------------------------------------
    | Hotspot
    |--------------------------------------------------------------------------
    */

    public function getHotspotUsers(): array;

    public function getActiveHotspotUsers(): array;

    public function createHotspot(
        string $username,
        string $password,
        string $profile = 'default'
    );

    public function findHotspot(string $username);

    public function deleteHotspot(string $username): bool;

    public function enableHotspot(string $username): bool;

    public function disableHotspot(string $username): bool;

    /*
    |--------------------------------------------------------------------------
    | DHCP
    |--------------------------------------------------------------------------
    */

    public function getDhcpLeases(): array;

    /*
    |--------------------------------------------------------------------------
    | Generic
    |--------------------------------------------------------------------------
    */

    public function run(Query $query): array;

    public function raw(string $command): array;
}
