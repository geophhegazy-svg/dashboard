<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Infrastructure\Providers\MikroTik;

use App\Exceptions\Network\QueryException;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikConnectionService;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikQueryService;
use RouterOS\Query;
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
