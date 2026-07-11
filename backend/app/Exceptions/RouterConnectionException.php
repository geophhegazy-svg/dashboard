<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class RouterConnectionException extends Exception
{
    public static function deviceNotFound(int $deviceId): self
    {
        return new self("Network device [{$deviceId}] was not found.");
    }

    public static function connectionFailed(string $deviceName): self
    {
        return new self("Unable to connect to MikroTik device [{$deviceName}].");
    }
}
