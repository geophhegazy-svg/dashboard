<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Resources\MigrationResource;
use Illuminate\Database\Migrations\Migrator;
use Tests\TestCase;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use Mockery;

final class MigrationResourceTest extends TestCase
{
    public function test_it_registers_module_migration_paths(): void
    {
        $path = database_path('migrations');
        $resource = new MigrationResource([$path]);

        $registrar = $this->app->make(
            ModuleRegistrarInterface::class
        );

        $resource->register($registrar);

        $this->assertContains(
            $path,
            $this->app->make(Migrator::class)->paths(),
        );
    }
}
