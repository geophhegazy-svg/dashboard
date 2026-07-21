<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Resources\ConfigResource;
use Tests\TestCase;

final class ConfigResourceTest extends TestCase
{
    public function test_it_registers_module_configuration(): void
    {
        $resource = new ConfigResource([
            'modules.subscription.grace_period_days' => 7,
        ]);

        $resource->register();

        $this->assertSame(
            7,
            config('modules.subscription.grace_period_days'),
        );
    }
}
