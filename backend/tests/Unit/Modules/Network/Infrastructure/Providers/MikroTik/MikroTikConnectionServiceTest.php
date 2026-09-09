<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Infrastructure\Providers\MikroTik;

use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikConnectionService;
use Tests\TestCase;

final class MikroTikConnectionServiceTest extends TestCase
{
    public function test_new_connection_service_is_not_connected(): void
    {
        $service = new MikroTikConnectionService();

        $this->assertFalse($service->isConnected());
        $this->assertNull($service->client());
    }

    public function test_ping_returns_false_when_not_connected(): void
    {
        $service = new MikroTikConnectionService();

        $this->assertFalse($service->ping());
    }

    public function test_disconnect_clears_connection_state(): void
    {
        $service = new MikroTikConnectionService();

        $service->disconnect();

        $this->assertFalse($service->isConnected());
        $this->assertNull($service->client());
    }
}
