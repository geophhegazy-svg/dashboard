<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Infrastructure\Providers\MikroTik;

use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\Services\DhcpServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\FirewallServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\MonitoringServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\PppoeServiceInterface;
use App\Modules\Network\Domain\Contracts\Services\QueueServiceInterface;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikConnectionService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikDhcpService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikFirewallService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikHotspotService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikMonitoringService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikPppoeService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikQueueService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikProvider;
use Mockery;
use Tests\TestCase;

final class MikroTikProviderTest extends TestCase
{
    public function test_provider_implements_network_provider_contract(): void
    {
        $provider = $this->provider();

        $this->assertInstanceOf(
            NetworkProviderInterface::class,
            $provider
        );

        $this->assertSame(
            'mikrotik',
            $provider->name()
        );
    }

    public function test_provider_exposes_all_supported_capabilities(): void
    {
        $provider = $this->provider();

        $this->assertSame(
            [
                'pppoe',
                'queue',
                'hotspot',
                'firewall',
                'dhcp',
                'monitoring',
            ],
            $provider->capabilities()
        );
    }

    public function test_provider_exposes_contract_services(): void
    {
        $provider = $this->provider();

        $this->assertInstanceOf(
            PppoeServiceInterface::class,
            $provider->pppoe()
        );

        $this->assertInstanceOf(
            QueueServiceInterface::class,
            $provider->queue()
        );

        $this->assertInstanceOf(
            HotspotServiceInterface::class,
            $provider->hotspot()
        );

        $this->assertInstanceOf(
            FirewallServiceInterface::class,
            $provider->firewall()
        );

        $this->assertInstanceOf(
            DhcpServiceInterface::class,
            $provider->dhcp()
        );

        $this->assertInstanceOf(
            MonitoringServiceInterface::class,
            $provider->monitoring()
        );
    }

    private function provider(): MikroTikProvider
    {
        return new MikroTikProvider(
            Mockery::mock(MikroTikConnectionService::class),
            Mockery::mock(MikroTikPppoeService::class),
            Mockery::mock(MikroTikQueueService::class),
            Mockery::mock(MikroTikHotspotService::class),
            Mockery::mock(MikroTikFirewallService::class),
            Mockery::mock(MikroTikDhcpService::class),
            Mockery::mock(MikroTikMonitoringService::class),
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
