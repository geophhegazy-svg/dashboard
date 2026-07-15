<?php

declare(strict_types=1);

namespace App\Exceptions\Network;

use RuntimeException;

class ResourceNotFoundException extends RuntimeException
{
    public function __construct(
        string $message = "",
        int $code = 0,
        ?\Throwable $previous = null,
        public readonly array $context = []
    ) {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }


    public static function missing(
        string $resource,
        array $context = []
    ): self {

        return new self(
            "Router resource '{$resource}' not found.",
            404,
            null,
            $context
        );
    }
}
