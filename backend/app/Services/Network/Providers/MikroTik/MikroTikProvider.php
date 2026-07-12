<?php

declare(strict_types=1);

namespace App\Services\Network\Providers\MikroTik;

use App\Contracts\Network\NetworkProviderInterface;
use App\Contracts\Network\Services\PppoeServiceInterface;
use App\Contracts\Network\Services\QueueServiceInterface;
use App\Contracts\Network\Services\HotspotServiceInterface;
use App\Contracts\Network\Services\FirewallServiceInterface;
use App\Contracts\Network\Services\DhcpServiceInterface;
use App\Contracts\Network\Services\MonitoringServiceInterface;

class MikroTikProvider implements NetworkProviderInterface
{

    public function __construct(
        protected MikroTikConnectionService $connection,
        protected MikroTikPppoeService $pppoe,
        protected MikroTikQueueService $queue,
        protected MikroTikHotspotService $hotspot,
        protected MikroTikFirewallService $firewall,
        protected MikroTikDhcpService $dhcp,
        protected MikroTikMonitoringService $monitoring
    ) {}



    /**
     * Connect router.
     */
    public function connect(
        string $host,
        string $username,
        string $password,
        int $port = 8728
    ): bool {

        return $this->connection->connect(
            $host,
            $username,
            $password,
            $port
        );
    }



    /**
     * Disconnect router.
     */
    public function disconnect(): void
    {
        $this->connection->disconnect();
    }



    /**
     * Connection status.
     */
    public function isConnected(): bool
    {
        return $this->connection->isConnected();
    }



    /**
     * Provider name.
     */
    public function name(): string
    {
        return 'mikrotik';
    }



    /**
     * Supported features.
     */
    public function capabilities(): array
    {
        return [
            'pppoe',
            'queue',
            'hotspot',
            'firewall',
            'dhcp',
            'monitoring',
        ];
    }



    /**
     * PPPoE service.
     */
    public function pppoe(): PppoeServiceInterface
    {
        return $this->pppoe;
    }



    /**
     * Queue service.
     */
    public function queue(): QueueServiceInterface
    {
        return $this->queue;
    }


    /**
     * Hotspot service.
     */
    public function hotspot(): HotspotServiceInterface
    {
        return $this->hotspot;
    }



    /**
     * Firewall service.
     */
    public function firewall(): FirewallServiceInterface
    {
        return $this->firewall;
    }



    /**
     * DHCP service.
     */
    public function dhcp(): DhcpServiceInterface
    {
        return $this->dhcp;
    }



    /**
     * Monitoring service.
     */
    public function monitoring(): MonitoringServiceInterface
    {
        return $this->monitoring;
    }
}
