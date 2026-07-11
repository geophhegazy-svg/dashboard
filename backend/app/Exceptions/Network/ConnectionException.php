<?php

declare(strict_types=1);

namespace App\Exceptions\Network;

use Throwable;

class ConnectionException extends MikroTikException
{
    /**
     * Create a connection exception.
     *
     * @param array<string,mixed> $context
     */
    public function __construct(
        string $message = 'Unable to connect to router.',
        int $code = 0,
        ?Throwable $previous = null,
        array $context = []
    ) {
        parent::__construct(
            $message,
            $code,
            $previous,
            $context
        );
    }


    /**
     * Create exception for unreachable router.
     *
     * @param array<string,mixed> $context
     */
    public static function unreachable(
        array $context = []
    ): self {
        return new self(
            'Router is unreachable.',
            503,
            null,
            $context
        );
    }


    /**
     * Create exception for authentication failure.
     *
     * @param array<string,mixed> $context
     */
    public static function authenticationFailed(
        array $context = []
    ): self {
        return new self(
            'Router authentication failed.',
            401,
            null,
            $context
        );
    }


    /**
     * Create exception for timeout.
     *
     * @param array<string,mixed> $context
     */
    public static function timeout(
        array $context = []
    ): self {
        return new self(
            'Router connection timeout.',
            408,
            null,
            $context
        );
    }
}
