<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

final class ValidationException extends CoreException
{
    public function __construct(
        array $errors,
        string $message = 'Validation failed',
    ) {
        parent::__construct(
            message: $message,
            codeName: 'VALIDATION_FAILED',
            context: [
                'errors' => $errors,
            ],
        );
    }

    public function errors(): array
    {
        return $this->context['errors'] ?? [];
    }
}
