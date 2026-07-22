<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use Mockery;
use Tests\TestCase;
use App\Core\Kernel\Resources\ConfigResource;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

final class ConfigResourceTest extends TestCase
{
    public function test_it_registers_module_configuration(): void
    {
        $registrar = Mockery::mock(
            ModuleRegistrarInterface::class
        );

        $registrar
            ->shouldReceive('registerConfig')
            ->once()
            ->with([
                'app.name' => 'EgyptNet',
            ]);

        $resource = new ConfigResource([
            'app.name' => 'EgyptNet',
        ]);

        $resource->register($registrar);

        $this->assertTrue(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
