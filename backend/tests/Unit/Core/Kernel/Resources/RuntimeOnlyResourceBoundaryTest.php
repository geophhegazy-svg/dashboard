<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\CompilableModuleResourceInterface;
use App\Core\Kernel\Contracts\ModuleResourceInterface;
use App\Core\Kernel\Resources\ConfigResource;
use App\Core\Kernel\Resources\RouteResource;
use App\Core\Kernel\Resources\ScheduleResource;
use PHPUnit\Framework\TestCase;

final class RuntimeOnlyResourceBoundaryTest extends TestCase
{
    public function test_config_resource_is_runtime_only(): void
    {
        $resource = new ConfigResource([
            'app.name' => 'EgyptNet',
        ]);

        $this->assertInstanceOf(
            ModuleResourceInterface::class,
            $resource,
        );

        $this->assertNotInstanceOf(
            CompilableModuleResourceInterface::class,
            $resource,
        );
    }

    public function test_route_resource_is_runtime_only(): void
    {
        $resource = new RouteResource(
            static function (): void {},
        );

        $this->assertInstanceOf(
            ModuleResourceInterface::class,
            $resource,
        );

        $this->assertNotInstanceOf(
            CompilableModuleResourceInterface::class,
            $resource,
        );
    }

    public function test_schedule_resource_is_runtime_only(): void
    {
        $resource = new ScheduleResource(
            static function (object $schedule): void {},
        );

        $this->assertInstanceOf(
            ModuleResourceInterface::class,
            $resource,
        );

        $this->assertNotInstanceOf(
            CompilableModuleResourceInterface::class,
            $resource,
        );
    }
}
