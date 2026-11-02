<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Infrastructure\Providers\MikroTik;

use App\Exceptions\Network\QueryException;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikConnectionService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikQueryService;
use RouterOS\Client;
use RouterOS\Query;
use Mockery;
use Tests\TestCase;

final class MikroTikQueryServiceTest extends TestCase
{
    private function service(): MikroTikQueryService
    {
        return new MikroTikQueryService(
            new MikroTikConnectionService()
        );
    }

    public function test_execute_throws_query_exception_when_not_connected(): void
    {
        $this->expectException(QueryException::class);

        $this->service()->execute(
            new Query('/system/resource/print')
        );
    }

    public function test_execute_normalizes_invalid_utf8_in_router_response(): void
    {
        $client = Mockery::mock(Client::class);
        $client->shouldReceive('query')
            ->once()
            ->with(Mockery::type(Query::class))
            ->andReturn($client);
        $client->shouldReceive('read')
            ->once()
            ->andReturn([
                [
                    'comment' => "\xFF\xFEprinter",
                    'host-name' => 'printer-01',
                    'nested' => ['label' => "ok\xFF"],
                ],
            ]);

        $service = new class(new MikroTikConnectionService(), $client) extends MikroTikQueryService {
            public function __construct(
                MikroTikConnectionService $connection,
                private Client $testClient
            ) {
                parent::__construct($connection);
            }

            protected function client(): Client
            {
                return $this->testClient;
            }
        };

        $result = $service->execute(new Query('/ip/dhcp-server/lease/print'));

        $this->assertSame('printer', $result[0]['comment']);
        $this->assertSame('printer-01', $result[0]['host-name']);
        $this->assertSame('ok', $result[0]['nested']['label']);
        $this->assertSame(
            $result,
            json_decode(json_encode($result, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR)
        );
    }

    public function test_first_throws_query_exception_when_not_connected(): void
    {
        $this->expectException(QueryException::class);

        $this->service()->first(
            new Query('/system/resource/print')
        );
    }

    public function test_write_returns_false_when_not_connected(): void
    {
        $result = $this->service()->write(
            new Query('/system/resource/print')
        );

        $this->assertFalse($result);
    }
}
