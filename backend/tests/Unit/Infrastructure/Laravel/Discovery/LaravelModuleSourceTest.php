<?php

declare(strict_types=1);

namespace Tests\Unit\Infrastructure\Laravel\Discovery;

use App\Core\Kernel\Modules\Module;
use App\Infrastructure\Laravel\Discovery\LaravelModuleSource;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

final class LaravelModuleSourceTest extends TestCase
{
    public function test_it_discovers_module_classes_from_modules_directory(): void
    {
        File::shouldReceive('exists')
            ->once()
            ->with(app_path('Modules'))
            ->andReturnTrue();

        File::shouldReceive('directories')
            ->once()
            ->with(app_path('Modules'))
            ->andReturn([
                app_path('Modules/Customer'),
            ]);

        $source = app(LaravelModuleSource::class);

        $modules = iterator_to_array($source->modules());

        self::assertCount(1, $modules);
        self::assertInstanceOf(
            Module::class,
            $modules[0]
        );
        self::assertSame(
            \App\Modules\Customer\Kernel\CustomerModule::class,
            $modules[0]::class
        );
    }

    public function test_it_returns_no_modules_when_modules_directory_does_not_exist(): void
    {
        File::shouldReceive('exists')
            ->once()
            ->with(app_path('Modules'))
            ->andReturnFalse();

        $source = app(LaravelModuleSource::class);

        self::assertSame(
            [],
            iterator_to_array($source->modules())
        );
    }

    public function test_it_skips_directories_without_a_matching_module_class(): void
    {
        File::shouldReceive('exists')
            ->once()
            ->with(app_path('Modules'))
            ->andReturnTrue();

        File::shouldReceive('directories')
            ->once()
            ->with(app_path('Modules'))
            ->andReturn([
                app_path('Modules/DoesNotExist'),
            ]);

        $source = app(LaravelModuleSource::class);

        self::assertSame(
            [],
            iterator_to_array($source->modules())
        );
    }

    public function test_it_implements_module_source_contract(): void
    {
        $source = app(LaravelModuleSource::class);

        self::assertInstanceOf(
            \App\Core\Kernel\Discovery\Contracts\ModuleSourceInterface::class,
            $source
        );
    }
}
