<?php

declare(strict_types=1);

namespace App\Core\Results;

final class SuccessResult extends Result
{
    public static function make(
        mixed $data = null,
        ?string $message = null,
        array $meta = [],
    ): self {
        return new self(
            success: true,
            data: $data,
            message: $message,
            meta: $meta,
        );
    }
}
