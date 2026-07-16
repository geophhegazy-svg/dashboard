<?php

declare(strict_types=1);

namespace App\Core\Results;

final class ValidationResult extends Result
{
    public static function make(
        array $errors,
        ?string $message = 'Validation failed',
        ?string $code = 'VALIDATION_FAILED',
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

    public function has(string $field): bool
    {
        return array_key_exists($field, $this->errors);
    }

    public function first(string $field): ?string
    {
        if (! isset($this->errors[$field])) {
            return null;
        }

        return $this->errors[$field][0] ?? null;
    }
}
