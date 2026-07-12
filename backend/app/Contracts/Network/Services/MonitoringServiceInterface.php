<?php

declare(strict_types=1);

namespace App\Contracts\Network\Services;

interface MonitoringServiceInterface
{
    /**
     * Router resources.
     *
     * @return array<string,mixed>
     */
    public function resources(): array;

    /**
     * Router interfaces.
     *
     * @return array<int,array<string,mixed>>
     */
    public function interfaces(): array;

    /**
     * Interface traffic.
     *
     * @return array<int,array<string,mixed>>
     */
    public function traffic(): array;

    /**
     * System health.
     *
     * @return array<string,mixed>
     */
    public function health(): array;

    /**
     * Active connections.
     *
     * @return array<int,array<string,mixed>>
     */
    public function activeConnections(): array;

    /**
     * CPU usage.
     */
    public function cpuUsage(): float;

    /**
     * Memory usage.
     */
    public function memoryUsage(): float;

    /**
     * Disk usage.
     */
    public function diskUsage(): float;

    /**
     * Router uptime.
     */
    public function uptime(): string;
}
