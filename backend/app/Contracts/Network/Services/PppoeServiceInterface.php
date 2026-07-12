<?php

declare(strict_types=1);

namespace App\Contracts\Network\Services;

interface PppoeServiceInterface
{
    /**
     * Get all PPPoE users.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getAll(): array;

    /**
     * Find PPPoE user.
     *
     * @return array<string,mixed>|null
     */
    public function find(string $username): ?array;

    /**
     * Check if user exists.
     */
    public function exists(string $username): bool;

    /**
     * Create PPPoE user.
     *
     * @param array<string,mixed> $attributes
     */
    public function create(array $attributes): bool;

    /**
     * Update PPPoE user.
     *
     * @param array<string,mixed> $attributes
     */
    public function update(
        string $username,
        array $attributes
    ): bool;

    /**
     * Delete PPPoE user.
     */
    public function delete(string $username): bool;

    /**
     * Enable PPPoE user.
     */
    public function enable(string $username): bool;

    /**
     * Disable PPPoE user.
     */
    public function disable(string $username): bool;

    /**
     * Change password.
     */
    public function changePassword(
        string $username,
        string $password
    ): bool;

    /**
     * Change profile.
     */
    public function changeProfile(
        string $username,
        string $profile
    ): bool;

    /**
     * Rename user.
     */
    public function rename(
        string $username,
        string $newUsername
    ): bool;

    /**
     * Update comment.
     */
    public function setComment(
        string $username,
        string $comment
    ): bool;

    /**
     * Reset counters.
     */
    public function resetCounters(
        string $username
    ): bool;

    /**
     * Get active sessions.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getActiveSessions(): array;

    /**
     * Disconnect active session.
     */
    public function disconnect(
        string $username
    ): bool;

    /**
     * Get online users.
     *
     * @return array<int,array<string,mixed>>
     */
    public function onlineUsers(): array;

    /**
     * Active users count.
     */
    public function activeCount(): int;

    /**
     * Search users.
     *
     * @return array<int,array<string,mixed>>
     */
    public function search(
        string $keyword
    ): array;

    /**
     * User statistics.
     *
     * @return array<string,mixed>
     */
    public function statistics(
        string $username
    ): array;

    /**
     * User traffic.
     *
     * @return array<string,mixed>
     */
    public function traffic(
        string $username
    ): array;

    /**
     * User uptime.
     */
    public function uptime(
        string $username
    ): int;

    /**
     * Profile usage.
     *
     * @return array<string,int>
     */
    public function profileUsage(): array;

    /**
     * Total users count.
     */
    public function totalCount(): int;

    /**
     * Disabled users count.
     */
    public function disabledCount(): int;
}
