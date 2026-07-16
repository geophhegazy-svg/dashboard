<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use Exception;
use Throwable;

class PlatformException extends Exception
{
    public function __construct(
        string $message = '',
        protected readonly ?string $errorCode = null,
        protected readonly array $context = [],
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct(
            $message,
            $code,
            $previous,
        );
    }

    public function errorCode(): ?string
    {
        return $this->errorCode;
    }

    public function context(): array
    {
        return $this->context;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->errorCode,
            'context' => $this->context,
        ];
    }
}
