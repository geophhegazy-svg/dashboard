<?php

declare(strict_types=1);

namespace App\Exceptions\Network;

use RuntimeException;
use Throwable;

class MikroTikException extends RuntimeException
{
    /**
     * @param array<string,mixed> $context
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        protected array $context = []
    ) {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }

    /**
     * @return array<string,mixed>
     */
    public function context(): array
    {
        return $this->context;
    }
}
