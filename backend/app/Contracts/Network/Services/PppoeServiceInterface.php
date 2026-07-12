<?php

declare(strict_types=1);

namespace App\Contracts\Network\Services;

interface PppoeServiceInterface
{
    /**
     * @return array<int,array<string,mixed>>
     */
    public function getAllUsers(): array;

    /**
     * @return array<string,mixed>|null
     */
    public function getUser(string $username): ?array;

    public function createUser(
        string $username,
        string $password,
        string $profile,
        array $options = []
    ): bool;

    public function updateUser(
        string $username,
        array $data
    ): bool;

    public function deleteUser(
        string $username
    ): bool;

    public function enableUser(
        string $username
    ): bool;

    public function disableUser(
        string $username
    ): bool;

    /**
     * @return array<int,array<string,mixed>>
     */
    public function getActiveSessions(): array;

    /**
     * @return array<string,mixed>|null
     */
    public function getActiveSession(
        string $username
    ): ?array;

    public function disconnectUser(
        string $username
    ): bool;

    public function updateProfile(
        string $username,
        string $profile
    ): bool;

    public function updatePassword(
        string $username,
        string $password
    ): bool;

    /**
     * @return array<int,array<string,mixed>>
     */
    public function searchUsers(
        string $keyword
    ): array;

    /**
     * @return array<string,mixed>
     */
    public function status(
        string $username
    ): array;
}
