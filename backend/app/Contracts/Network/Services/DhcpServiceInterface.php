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
    public function getAll(): array;

    /**
     * Find lease by IP.
     *
     * @return array<string,mixed>|null
     */
    public function find(
        string $value
    ): ?array;

    /**
     * Find lease by MAC address.
     *
     * @return array<string,mixed>|null
     */
    public function findByMac(
        string $macAddress
    ): ?array;

    /**
     * Create DHCP lease.
     *
     * @param array<string,mixed> $attributes
     */
    public function create(
        string $address,
        string $macAddress,
        ?string $hostname = null,
        array $options = []
    ): bool;

    /**
     * Update DHCP lease.
     *
     * @param array<string,mixed> $attributes
     */
    public function update(
        string $id,
        array $data
    ): bool;

    /**
     * Delete DHCP lease.
     */
    public function delete(
        string $id
    ): bool;

    /**
     * Convert dynamic lease to static.
     */
    public function makeStatic(
        string $id
    ): bool;

    /**
     * Remove static lease.
     */
    public function removeStatic(
        string $id
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
     * Get active DHCP clients.
     *
     * @return array<int,array<string,mixed>>
     */
    public function activeClients(): array;

    /**
     * DHCP statistics.
     *
     * @return array<string,mixed>
     */
    public function statistics(): array;
}
