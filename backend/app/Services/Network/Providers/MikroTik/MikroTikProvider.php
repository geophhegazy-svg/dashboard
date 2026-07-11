<?php

declare(strict_types=1);

namespace App\Services\Network\Providers\MikroTik;

use App\Contracts\Network\NetworkProviderInterface;

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
    public function pppoe(): MikroTikPppoeService
    {
        return $this->pppoe;
    }



    /**
     * Queue service.
     */
    public function queue(): MikroTikQueueService
    {
        return $this->queue;
    }



    /**
     * Hotspot service.
     */
    public function hotspot(): MikroTikHotspotService
    {
        return $this->hotspot;
    }



    /**
     * Firewall service.
     */
    public function firewall(): MikroTikFirewallService
    {
        return $this->firewall;
    }



    /**
     * DHCP service.
     */
    public function dhcp(): MikroTikDhcpService
    {
        return $this->dhcp;
    }



    /**
     * Monitoring service.
     */
    public function monitoring(): MikroTikMonitoringService
    {
        return $this->monitoring;
    }
}
