<?php

declare(strict_types=1);

namespace App\Core\Workflow\Result;

use App\Core\Workflow\Contracts\WorkflowResultInterface;

final readonly class WorkflowResult implements WorkflowResultInterface
{
    /**
     * @param array<int, mixed> $errors
     * @param array<string, mixed> $metadata
     * @param array<int, object> $events
     */
    public function __construct(
        private bool $successful = true,
        private mixed $payload = null,
        private array $errors = [],
        private array $metadata = [],
        private array $events = [],
    ) {}

    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    public function payload(): mixed
    {
        return $this->payload;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function metadata(): array
    {
        return $this->metadata;
    }

    public function events(): array
    {
        return $this->events;
    }

    public function withPayload(mixed $payload): static
    {
        return new self(
            $this->successful,
            $payload,
            $this->errors,
            $this->metadata,
            $this->events,
        );
    }

    public function withErrors(array $errors): static
    {
        return new self(
            false,
            $this->payload,
            $errors,
            $this->metadata,
            $this->events,
        );
    }

    public function withMetadata(array $metadata): static
    {
        return new self(
            $this->successful,
            $this->payload,
            $this->errors,
            array_replace($this->metadata, $metadata),
            $this->events,
        );
    }

    public function addEvent(object $event): static
    {
        return new self(
            $this->successful,
            $this->payload,
            $this->errors,
            $this->metadata,
            [
                ...$this->events,
                $event,
            ],
        );
    }
}
