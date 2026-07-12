<?php

declare(strict_types=1);

namespace App\Contracts\Network\Services;

interface QueueServiceInterface
{
    /**
     * Get all queues.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getAll(): array;

    /**
     * Find queue.
     *
     * @return array<string,mixed>|null
     */
    public function find(string $name): ?array;

    /**
     * Create queue.
     */
    public function create(
        string $name,
        string $target,
        string $maxLimit,
        ?string $limitAt = null,
        int $priority = 1,
        array $options = []
    ): bool;

    /**
     * Update queue.
     *
     * @param array<string,mixed> $data
     */
    public function update(
        string $name,
        array $data
    ): bool;

    /**
     * Delete queue.
     */
    public function delete(string $name): bool;

    /**
     * Enable queue.
     */
    public function enable(string $name): bool;

    /**
     * Disable queue.
     */
    public function disable(string $name): bool;

    /**
     * Get queue usage.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getUsage(): array;

    /**
     * Get queue by username.
     *
     * @return array<string,mixed>|null
     */
    public function getUserQueue(
        string $username
    ): ?array;

    /**
     * Update speed.
     */
    public function updateSpeed(
        string $username,
        string $download,
        string $upload
    ): bool;

    /**
     * Reset counters.
     */
    public function resetCounters(
        string $name
    ): bool;

    /**
     * Search queues.
     *
     * @return array<int,array<string,mixed>>
     */
    public function search(
        string $keyword
    ): array;

    /**
     * Queue statistics.
     *
     * @return array<string,mixed>
     */
    public function statistics(
        string $name
    ): array;
}
