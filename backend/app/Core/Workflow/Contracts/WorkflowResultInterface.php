<?php

declare(strict_types=1);

namespace App\Core\Workflow\Contracts;

interface WorkflowResultInterface
{
    public function isSuccessful(): bool;

    public function payload(): mixed;

    /**
     * @return array<int, mixed>
     */
    public function errors(): array;

    /**
     * @return array<string, mixed>
     */
    public function metadata(): array;

    /**
     * @return array<int, object>
     */
    public function events(): array;

    public function withPayload(mixed $payload): static;

    /**
     * @param array<int, mixed> $errors
     */
    public function withErrors(array $errors): static;

    /**
     * @param array<string, mixed> $metadata
     */
    public function withMetadata(array $metadata): static;

    public function addEvent(object $event): static;
}
