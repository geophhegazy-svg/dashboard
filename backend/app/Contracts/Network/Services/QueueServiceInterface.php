<?php

declare(strict_types=1);

namespace App\Contracts\Network\Services;

interface QueueServiceInterface
{
    /**
     * @return array<int,array<string,mixed>>
     */
    public function getAll(): array;

    /**
     * @return array<string,mixed>|null
     */
    public function find(
        string $name
    ): ?array;

    public function create(
        string $name,
        string $target,
        string $maxLimit,
        ?string $limitAt = null,
        int $priority = 1,
        array $options = []
    ): bool;

    public function update(
        string $name,
        array $data
    ): bool;

    public function delete(
        string $name
    ): bool;

    public function disable(
        string $name
    ): bool;

    public function enable(
        string $name
    ): bool;

    /**
     * @return array<int,array<string,mixed>>
     */
    public function getUsage(): array;

    /**
     * @return array<string,mixed>|null
     */
    public function getUserQueue(
        string $username
    ): ?array;

    public function updateSpeed(
        string $username,
        string $download,
        string $upload
    ): bool;

    public function resetCounters(
        string $name
    ): bool;

    /**
     * @return array<int,array<string,mixed>>
     */
    public function search(
        string $keyword
    ): array;

    /**
     * @return array<string,mixed>
     */
    public function statistics(
        string $name
    ): array;
}
