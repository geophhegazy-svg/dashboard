<?php

declare(strict_types=1);

namespace App\Contracts\Network\Services;

interface DhcpServiceInterface
{
    /**
     * Get all DHCP leases.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getLeases(): array;

    /**
     * Find lease by IP or MAC.
     *
     * @return array<string,mixed>|null
     */
    public function find(string $value): ?array;

    /**
     * Add static lease.
     */
    public function createLease(
        string $ipAddress,
        string $macAddress,
        string $comment = ''
    ): bool;

    /**
     * Remove lease.
     */
    public function deleteLease(
        string $ipAddress
    ): bool;

    /**
     * Enable lease.
     */
    public function enableLease(
        string $ipAddress
    ): bool;

    /**
     * Disable lease.
     */
    public function disableLease(
        string $ipAddress
    ): bool;

    /**
     * Search leases.
     *
     * @return array<int,array<string,mixed>>
     */
    public function search(
        string $keyword
    ): array;

    /**
     * DHCP statistics.
     *
     * @return array<string,mixed>
     */
    public function statistics(): array;
}
