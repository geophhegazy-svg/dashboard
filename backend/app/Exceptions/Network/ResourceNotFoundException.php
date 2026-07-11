<?php

declare(strict_types=1);

namespace App\Exceptions\Network;

use Throwable;

class ResourceNotFoundException extends MikroTikException
{
    /**
     * Create resource not found exception.
     *
     * @param array<string,mixed> $context
     */
    public function __construct(
        string $message = 'Router resource not found.',
        int $code = 404,
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
     * Create exception for missing resource.
     *
     * @param string $resource
     * @param array<string,mixed> $context
     */
    public static function missing(
        string $resource,
        array $context = []
    ): self {
        return new self(
            "Router resource not found: {$resource}.",
            404,
            null,
            array_merge(
                $context,
                [
                    'resource' => $resource,
                ]
            )
        );
    }
}
