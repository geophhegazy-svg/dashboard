<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Bus;

use App\Core\ActionBus\ActionDispatcher;
use App\Core\ActionBus\ActionRegistry;
use App\Core\CommandBus\CommandDispatcher;
use App\Core\CommandBus\CommandRegistry;
use App\Core\QueryBus\QueryDispatcher;
use App\Core\QueryBus\QueryRegistry;
use App\Core\Workflow\WorkflowEngine;
use Tests\TestCase;

final class KernelBusServiceProviderTest extends TestCase
{
    public function test_bus_registries_are_registered_as_singletons(): void
    {
        self::assertSame(
            $this->app->make(ActionRegistry::class),
            $this->app->make(ActionRegistry::class),
        );

        self::assertSame(
            $this->app->make(QueryRegistry::class),
            $this->app->make(QueryRegistry::class),
        );

        self::assertSame(
            $this->app->make(CommandRegistry::class),
            $this->app->make(CommandRegistry::class),
        );
    }

    public function test_bus_dispatchers_are_registered_as_singletons(): void
    {
        self::assertSame(
            $this->app->make(ActionDispatcher::class),
            $this->app->make(ActionDispatcher::class),
        );

        self::assertSame(
            $this->app->make(QueryDispatcher::class),
            $this->app->make(QueryDispatcher::class),
        );

        self::assertSame(
            $this->app->make(CommandDispatcher::class),
            $this->app->make(CommandDispatcher::class),
        );
    }

    public function test_workflow_engine_is_registered_as_singleton(): void
    {
        self::assertSame(
            $this->app->make(WorkflowEngine::class),
            $this->app->make(WorkflowEngine::class),
        );
    }
}
