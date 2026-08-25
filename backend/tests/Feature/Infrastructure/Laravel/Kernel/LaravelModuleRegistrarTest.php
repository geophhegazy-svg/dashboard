<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Laravel\Kernel;

use App\Core\ActionBus\ActionRegistry;
use App\Core\CommandBus\CommandRegistry;
use App\Core\EventBus\EventRegistry;
use App\Core\EventBus\Contracts\EventContract;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\QueryBus\QueryRegistry;
use App\Infrastructure\Laravel\Kernel\LaravelModuleRegistrar;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

final class LaravelModuleRegistrarTest extends TestCase
{
    public function test_registrar_is_bound_to_module_registrar_contract(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        self::assertInstanceOf(
            LaravelModuleRegistrar::class,
            $registrar,
        );
    }

    public function test_bind_registers_transient_binding(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $abstract = RegistrarBindContract::class;
        $concrete = RegistrarBindImplementation::class;

        $registrar->bind(
            $abstract,
            $concrete,
        );

        self::assertInstanceOf(
            $concrete,
            $this->app->make($abstract),
        );
    }

    public function test_singleton_registers_singleton_binding(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $abstract = RegistrarSingletonContract::class;
        $concrete = RegistrarSingletonImplementation::class;

        $registrar->singleton(
            $abstract,
            $concrete,
        );

        self::assertSame(
            $this->app->make($abstract),
            $this->app->make($abstract),
        );
    }

    public function test_register_action_registers_action(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $registrar->registerAction(
            RegistrarAction::class,
        );

        self::assertTrue(
            $this->app
                ->make(ActionRegistry::class)
                ->has(RegistrarAction::class),
        );
    }

    public function test_register_query_registers_query_handler(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $registrar->registerQuery(
            RegistrarQuery::class,
            RegistrarQueryHandler::class,
        );

        $descriptor = $this->app
            ->make(QueryRegistry::class)
            ->get(RegistrarQuery::class);

        self::assertNotNull($descriptor);
        self::assertSame(
            RegistrarQueryHandler::class,
            $descriptor->handler,
        );
    }

    public function test_register_listener_registers_listener(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $registrar->registerListener(
            RegistrarEvent::class,
            RegistrarListener::class,
        );

        $event = new RegistrarEvent();

        self::assertContains(
            RegistrarListener::class,
            $this->app
                ->make(EventRegistry::class)
                ->listenersFor($event),
        );
    }

    public function test_register_policy_registers_policy(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $registrar->registerPolicy(
            RegistrarPolicyModel::class,
            RegistrarPolicy::class,
        );

        self::assertInstanceOf(
            RegistrarPolicy::class,
            Gate::getPolicyFor(
                RegistrarPolicyModel::class,
            ),
        );
    }

    public function test_register_route_registers_route_with_prefix_and_middleware(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $prefix = 'registrar-test';

        $registrar->registerRoute(
            static function (): void {
                Route::get(
                    '/health',
                    static fn (): array => ['ok' => true],
                );
            },
            $prefix,
            ['api'],
        );

        $route = collect(
            Route::getRoutes()->getRoutes(),
        )->first(
            static fn ($route): bool =>
                $route->uri() === "{$prefix}/health",
        );

        self::assertNotNull($route);
        self::assertContains(
            'api',
            $route->gatherMiddleware(),
        );
    }

    public function test_register_migration_registers_paths(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $path = base_path(
            'database/migrations',
        );

        $registrar->registerMigration([$path]);

        self::assertContains(
            $path,
            $this->app
                ->make(Migrator::class)
                ->paths(),
        );
    }

    public function test_register_command_registers_command_class(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $command = RegistrarConsoleCommand::class;

        $registrar->registerCommand($command);

        $kernel = $this->app->make(
            \Illuminate\Contracts\Console\Kernel::class,
        );

        $reflection = new \ReflectionClass($kernel);

        $property = $reflection->getProperty(
            'commands',
        );

        $property->setAccessible(true);

        $commands = $property->getValue($kernel);

        self::assertContains(
            $command,
            $commands,
        );
    }

    public function test_register_schedule_registers_schedule_callback(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $registrar->registerSchedule(
            static function (Schedule $schedule): void {
                $schedule->call(
                    static fn (): bool => true,
                )->daily();
            },
        );

        self::assertNotEmpty(
            $this->app
                ->make(Schedule::class)
                ->events(),
        );
    }

    public function test_register_config_registers_configuration(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $registrar->registerConfig([
            'registrar_test.value' => 'registered',
        ]);

        self::assertSame(
            'registered',
            config('registrar_test.value'),
        );
    }

    public function test_register_command_handler_registers_command_handler(): void
    {
        $registrar = $this->app->make(
            ModuleRegistrarInterface::class,
        );

        $registrar->registerCommandHandler(
            RegistrarCommand::class,
            RegistrarCommandHandler::class,
        );

        $descriptor = $this->app
            ->make(CommandRegistry::class)
            ->get(RegistrarCommand::class);

        self::assertNotNull($descriptor);
        self::assertSame(
            RegistrarCommandHandler::class,
            $descriptor->handler,
        );
    }
}

class RegistrarBindContract
{
}

final class RegistrarBindImplementation extends RegistrarBindContract
{
}

class RegistrarSingletonContract
{
}

final class RegistrarSingletonImplementation extends RegistrarSingletonContract
{
}

final class RegistrarAction
{
}

final class RegistrarQuery
{
}

final class RegistrarQueryHandler
{
}

final class RegistrarEvent implements EventContract
{
}

final class RegistrarListener
{
}

final class RegistrarPolicyModel
{
}

final class RegistrarPolicy
{
}

final class RegistrarCommand
{
}

final class RegistrarCommandHandler
{
}

final class RegistrarConsoleCommand
{
}
