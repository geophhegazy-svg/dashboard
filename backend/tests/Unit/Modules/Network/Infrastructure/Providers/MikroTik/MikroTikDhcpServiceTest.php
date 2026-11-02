<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Infrastructure\Providers\MikroTik;

use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikDhcpService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikQueryService;
use Mockery;
use RouterOS\Query;
use Tests\TestCase;

final class MikroTikDhcpServiceTest extends TestCase
{
    public function test_update_maps_hostname_and_mac_address_to_routeros_field_names(): void
    {
        $queryService = Mockery::mock(MikroTikQueryService::class);

        $queryService->shouldReceive('execute')
            ->once()
            ->with(Mockery::type(Query::class))
            ->andReturn([
                [
                    '.id' => '*1',
                    'address' => '192.0.2.20',
                    'mac-address' => 'AA:BB:CC:DD:EE:FF',
                ],
            ]);

        $queryService->shouldReceive('write')
            ->once()
            ->with(Mockery::on(function (Query $query): bool {
                $this->assertSame(
                    '/ip/dhcp-server/lease/set',
                    $query->getEndpoint(),
                );

                $this->assertSame(
                    [
                        '/ip/dhcp-server/lease/set',
                        '=.id=*1',
                        '=host-name=printer-01',
                        '=mac-address=AA:BB:CC:DD:EE:FF',
                        '=address=192.0.2.21',
                    ],
                    $query->getQuery(),
                );

                return true;
            }))
            ->andReturn(true);

        $service = new MikroTikDhcpService($queryService);

        $this->assertTrue($service->update('*1', [
            'hostname' => 'printer-01',
            'mac_address' => 'AA:BB:CC:DD:EE:FF',
            'address' => '192.0.2.21',
        ]));
    }
}
