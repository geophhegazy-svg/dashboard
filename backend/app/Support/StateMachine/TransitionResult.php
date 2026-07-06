<?php

declare(strict_types=1);

namespace App\Support\StateMachine;

final readonly class TransitionResult
{
    public function __construct(
        public bool $success,
        public ?string $message = null,
    ) {}

    public static function success(?string $message = null): self
    {
        return new self(true, $message);
    }

    public static function failure(string $message): self
    {
        return new self(false, $message);
    }
}
