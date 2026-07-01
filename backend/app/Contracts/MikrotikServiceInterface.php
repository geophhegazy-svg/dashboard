<?php

declare(strict_types=1);

namespace App\Contracts;

interface MikrotikServiceInterface
{
    public function enablePppoe(string $username): bool;

    public function disablePppoe(string $username): bool;

    public function enableHotspot(string $username): bool;

    public function disableHotspot(string $username): bool;
}
