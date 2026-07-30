<?php

declare(strict_types=1);

namespace App\Core\Workflow\Contracts;

interface WorkflowContextInterface
{
    public function dto(): mixed;

    public function actor(): mixed;

    public function get(string $key, mixed $default = null): mixed;

    public function set(string $key, mixed $value): static;

    public function has(string $key): bool;

    public function remove(string $key): static;

    /**
     * @return array<string, mixed>
     */
    public function all(): array;

    /**
     * @return array<string, mixed>
     */
    public function metadata(): array;

    /**
     * @param array<string, mixed> $metadata
     */
    public function withMetadata(array $metadata): static;
}
