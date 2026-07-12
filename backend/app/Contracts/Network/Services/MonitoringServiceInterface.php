<?php

declare(strict_types=1);

namespace App\Contracts\Network\Services;

interface MonitoringServiceInterface
{
    /**
     * Get router system resources.
     *
     * @return array<string,mixed>
     */
    public function getSystemResource(): array;

    /**
     * Get router identity.
     *
     * @return array<string,mixed>
     */
    public function getIdentity(): array;

    /**
     * Get all interfaces.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getInterfaces(): array;

    /**
     * Get interface traffic.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getInterfaceTraffic(): array;

    /**
     * Ping host.
     */
    public function ping(
        string $address,
        int $count = 3
    ): bool;

    /**
     * Health check.
     *
     * @return array<string,mixed>
     */
    public function healthCheck(): array;

    /**
     * Monitoring summary.
     *
     * @return array<string,mixed>
     */
    public function summary(): array;
}
