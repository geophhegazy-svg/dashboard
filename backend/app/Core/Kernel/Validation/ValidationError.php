<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation;

final readonly class ValidationError
{
    public function __construct(
        private ValidationErrorCode $code,
        private string $message,
    ) {}

    public function code(): ValidationErrorCode
    {
        return $this->code;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function format(): string
    {
        return sprintf(
            '[%s] %s',
            $this->code->value,
            $this->message,
        );
    }
}
