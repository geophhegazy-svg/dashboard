<?php

declare(strict_types=1);

namespace App\Contracts\Network;

use App\Contracts\Network\Services\PppoeServiceInterface;
use App\Contracts\Network\Services\QueueServiceInterface;
use App\Contracts\Network\Services\HotspotServiceInterface;
use App\Contracts\Network\Services\FirewallServiceInterface;
use App\Contracts\Network\Services\DhcpServiceInterface;
use App\Contracts\Network\Services\MonitoringServiceInterface;

interface NetworkProviderInterface
{
    /**
     * Connect to router.
     */
    public function connect(
        string $host,
        string $username,
        string $password,
        int $port = 8728
    ): bool;

    /**
     * Disconnect.
     */
    public function disconnect(): void;

    /**
     * Connection state.
     */
    public function isConnected(): bool;

    /**
     * Provider name.
     */
    public function name(): string;

    /**
     * Supported capabilities.
     *
     * @return array<int,string>
     */
    public function capabilities(): array;

    /**
     * PPPoE service.
     */
    public function pppoe(): PppoeServiceInterface;

    /**
     * Queue service.
     */
    public function queue(): QueueServiceInterface;

    /**
     * Hotspot service.
     */
    public function hotspot(): HotspotServiceInterface;

    /**
     * Firewall service.
     */
    public function firewall(): FirewallServiceInterface;

    /**
     * DHCP service.
     */
    public function dhcp(): DhcpServiceInterface;

    /**
     * Monitoring service.
     */
    public function monitoring(): MonitoringServiceInterface;
}
