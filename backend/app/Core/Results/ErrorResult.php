<?php

declare(strict_types=1);

namespace App\Core\Results;

final class ErrorResult extends Result
{
    public static function make(
        ?string $message = null,
        ?string $code = null,
        array $errors = [],
        mixed $data = null,
        array $meta = [],
    ): self {
        return new self(
            success: false,
            data: $data,
            message: $message,
            errors: $errors,
            code: $code,
            meta: $meta,
        );
    }
}
