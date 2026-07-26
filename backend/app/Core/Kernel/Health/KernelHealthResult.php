<?php

declare(strict_types=1);

namespace App\Core\Kernel\Health;

final readonly class KernelHealthResult
{
    public function __construct(
        private string $name,
        private bool $passed,
        private string $message,
    ) {}


    public function name(): string
    {
        return $this->name;
    }


    public function passed(): bool
    {
        return $this->passed;
    }


    public function message(): string
    {
        return $this->message;
    }
}
