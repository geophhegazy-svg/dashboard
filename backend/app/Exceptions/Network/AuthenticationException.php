<?php

declare(strict_types=1);

namespace App\Exceptions\Network;

use Throwable;

class AuthenticationException extends MikroTikException
{
    /**
     * Create an authentication exception.
     *
     * @param array<string,mixed> $context
     */
    public function __construct(
        string $message = 'Router authentication failed.',
        int $code = 401,
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
     * Invalid credentials.
     *
     * @param array<string,mixed> $context
     */
    public static function invalidCredentials(
        array $context = []
    ): self {
        return new self(
            'Invalid router credentials.',
            401,
            null,
            $context
        );
    }


    /**
     * User does not have required permissions.
     *
     * @param array<string,mixed> $context
     */
    public static function insufficientPermissions(
        array $context = []
    ): self {
        return new self(
            'Router user does not have sufficient permissions.',
            403,
            null,
            $context
        );
    }
}
