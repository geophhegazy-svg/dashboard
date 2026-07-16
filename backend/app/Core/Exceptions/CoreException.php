<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Exceptions\Contracts\ExceptionInterface;
use Exception;

abstract class CoreException extends Exception implements ExceptionInterface
{
    public function __construct(
        string $message = '',
        protected ?string $codeName = null,
        protected array $context = [],
        int $code = 0,
        ?Exception $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function codeName(): ?string
    {
        return $this->codeName;
    }

    public function context(): array
    {
        return $this->context;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'code_name' => $this->codeName,
            'context' => $this->context,
        ];
    }
}
