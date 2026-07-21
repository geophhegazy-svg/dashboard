<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Resources\MigrationResource;
use Illuminate\Database\Migrations\Migrator;
use Tests\TestCase;

final class MigrationResourceTest extends TestCase
{
    public function test_it_registers_module_migration_paths(): void
    {
        $path = database_path('migrations');
        $resource = new MigrationResource([$path]);

        $resource->register();

        $this->assertContains(
            $path,
            $this->app->make(Migrator::class)->paths(),
        );
    }
}
