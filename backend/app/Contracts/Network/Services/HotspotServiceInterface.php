<?php

declare(strict_types=1);

namespace App\Contracts\Network\Services;

interface HotspotServiceInterface
{
    /**
     * Get all hotspot users.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getUsers(): array;

    /**
     * Get active hotspot sessions.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getActiveSessions(): array;

    /**
     * Find hotspot user.
     *
     * @return array<string,mixed>|null
     */
    public function findUser(string $username): ?array;

    /**
     * Create hotspot user.
     *
     * @param array<string,mixed> $options
     */
    public function createUser(
        string $username,
        string $password,
        string $profile,
        array $options = []
    ): bool;

    /**
     * Update hotspot user.
     *
     * @param array<string,mixed> $data
     */
    public function updateUser(
        string $username,
        array $data
    ): bool;

    /**
     * Delete hotspot user.
     */
    public function deleteUser(
        string $username
    ): bool;

    /**
     * Enable hotspot user.
     */
    public function enableUser(
        string $username
    ): bool;

    /**
     * Disable hotspot user.
     */
    public function disableUser(
        string $username
    ): bool;

    /**
     * Disconnect active session.
     */
    public function disconnectUser(
        string $username
    ): bool;

    /**
     * Search hotspot users.
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
}
