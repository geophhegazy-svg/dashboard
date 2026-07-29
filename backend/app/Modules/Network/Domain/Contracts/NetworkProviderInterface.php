<?php

declare(strict_types=1);

namespace App\Modules\Network\Domain\Contracts;

use App\Modules\Network\Domain\Contracts\Services\PppoeServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\QueueServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\FirewallServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\DhcpServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\MonitoringServiceInterface;

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
