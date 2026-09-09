<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Infrastructure\Providers\MikroTik;

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

    public function test_execute_returns_empty_array_when_not_connected(): void
    {
        $result = $this->service()->execute(
            new Query('/system/resource/print')
        );

        $this->assertSame([], $result);
    }

    public function test_first_returns_null_when_not_connected(): void
    {
        $result = $this->service()->first(
            new Query('/system/resource/print')
        );

        $this->assertNull($result);
    }

    public function test_write_returns_false_when_not_connected(): void
    {
        $result = $this->service()->write(
            new Query('/system/resource/print')
        );

        $this->assertFalse($result);
    }
}
