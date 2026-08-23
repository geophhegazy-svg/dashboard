<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Registration\Handlers\MigrationResourceHandler;
use App\Core\Kernel\Resources\ResourceType;
use Mockery;
use Tests\TestCase;

final class MigrationResourceHandlerTest extends TestCase
{
    public function test_it_supports_migration_resources(): void
    {
        $handler = new MigrationResourceHandler();

        self::assertTrue(
            $handler->supports(ResourceType::Migrations->value),
        );

        self::assertFalse(
            $handler->supports(ResourceType::Services->value),
        );
    }

    public function test_it_registers_compiled_migration_paths(): void
    {
        $paths = [
            '/var/www/database/migrations',
            '/var/www/app/Modules/Test/Database/Migrations',
        ];

        $registrar = Mockery::mock(
            ModuleRegistrarInterface::class,
        );

        $registrar
            ->shouldReceive('registerMigration')
            ->once()
            ->with($paths);

        $handler = new MigrationResourceHandler();

        $handler->register(
            [
                'type' => ResourceType::Migrations->value,
                'paths' => $paths,
            ],
            $registrar,
        );

        self::addToAssertionCount(1);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
