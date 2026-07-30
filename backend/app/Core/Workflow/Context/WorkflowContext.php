<?php

declare(strict_types=1);

namespace App\Core\Workflow\Context;

use App\Core\Workflow\Contracts\WorkflowContextInterface;

final class WorkflowContext implements WorkflowContextInterface
{
    /**
     * @var array<string, mixed>
     */
    private array $attributes = [];

    /**
     * @var array<string, mixed>
     */
    private array $metadata = [];

    public function __construct(
        private readonly mixed $dto,
        private readonly mixed $actor = null,
    ) {}

    public function dto(): mixed
    {
        return $this->dto;
    }

    public function actor(): mixed
    {
        return $this->actor;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->attributes[$key] ?? $default;
    }

    public function set(string $key, mixed $value): static
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
    }

    public function remove(string $key): static
    {
        unset($this->attributes[$key]);

        return $this;
    }

    public function all(): array
    {
        return $this->attributes;
    }

    public function metadata(): array
    {
        return $this->metadata;
    }

    public function withMetadata(array $metadata): static
    {
        $this->metadata = array_replace($this->metadata, $metadata);

        return $this;
    }
}
