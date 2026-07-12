<?php

declare(strict_types=1);

namespace App\Contracts\Network\Services;

interface FirewallServiceInterface
{
    /**
     * Get all firewall rules.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getAll(): array;

    /**
     * Find firewall rule.
     *
     * @return array<string,mixed>|null
     */
    public function find(string $comment): ?array;

    /**
     * Create firewall rule.
     *
     * @param array<string,mixed> $attributes
     */
    public function create(array $attributes): bool;

    /**
     * Update firewall rule.
     *
     * @param array<string,mixed> $attributes
     */
    public function update(
        string $comment,
        array $attributes
    ): bool;

    /**
     * Delete firewall rule.
     */
    public function delete(
        string $comment
    ): bool;

    /**
     * Enable firewall rule.
     */
    public function enable(
        string $comment
    ): bool;

    /**
     * Disable firewall rule.
     */
    public function disable(
        string $comment
    ): bool;

    /**
     * Move firewall rule.
     */
    public function move(
        string $comment,
        int $position
    ): bool;

    /**
     * Search firewall rules.
     *
     * @return array<int,array<string,mixed>>
     */
    public function search(
        string $keyword
    ): array;

    /**
     * Firewall statistics.
     *
     * @return array<string,mixed>
     */
    public function statistics(
        string $comment
    ): array;
}
