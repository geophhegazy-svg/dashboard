<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration\Planner;

final readonly class RegistrationStep
{
    /**
     * @param array<string,mixed> $resource
     */
    public function __construct(
        private string $module,
        private array $resource,
    ) {}

    public function module(): string
    {
        return $this->module;
    }

    /**
     * @return array<string,mixed>
     */
    public function resource(): array
    {
        return $this->resource;
    }

    public function type(): string
    {
        return $this->resource['type'];
    }
}
