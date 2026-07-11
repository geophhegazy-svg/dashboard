<?php

declare(strict_types=1);

namespace App\Exceptions\Network;

use Throwable;

class QueryException extends MikroTikException
{
    /**
     * Create query exception.
     *
     * @param array<string,mixed> $context
     */
    public function __construct(
        string $message = 'Router query execution failed.',
        int $code = 500,
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
     * Invalid command.
     *
     * @param array<string,mixed> $context
     */
    public static function invalidCommand(
        array $context = []
    ): self {
        return new self(
            'Invalid router command.',
            400,
            null,
            $context
        );
    }


    /**
     * Query execution failed.
     *
     * @param array<string,mixed> $context
     */
    public static function failed(
        array $context = []
    ): self {
        return new self(
            'Router command execution failed.',
            500,
            null,
            $context
        );
    }
}
