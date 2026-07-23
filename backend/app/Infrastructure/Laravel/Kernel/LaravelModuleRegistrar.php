<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Kernel;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\ActionBus\ActionRegistry;
use App\Core\QueryBus\QueryRegistry;
use App\Core\EventBus\EventRegistry;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Console\Scheduling\Schedule;
use Closure;
use App\Core\CommandBus\CommandRegistry;

final readonly class LaravelModuleRegistrar implements ModuleRegistrarInterface
{
    public function __construct(
        private Application $app,
    ) {}


    public function bind(
        string $abstract,
        string $concrete
    ): void {

        $this->app->bind(
            $abstract,
            $concrete
        );
    }


    public function singleton(
        string $abstract,
        string $concrete
    ): void {

        $this->app->singleton(
            $abstract,
            $concrete
        );
    }


    public function registerAction(
        string $action
    ): void {

        $this->app
            ->make(ActionRegistry::class)
            ->register($action);
    }


    public function registerQuery(
        string $query,
        string $handler
    ): void {

        $this->app
            ->make(QueryRegistry::class)
            ->register(
                $query,
                $handler
            );
    }


    public function registerListener(
        string $event,
        string $listener
    ): void {

        $this->app
            ->make(EventRegistry::class)
            ->register(
                $event,
                $listener
            );
    }


    public function registerPolicy(
        string $model,
        string $policy
    ): void {

        Gate::policy(
            $model,
            $policy
        );
    }


    public function registerRoute(
        Closure|string $routes,
        string $prefix,
        array $middleware
    ): void {

        Route::middleware($middleware)
            ->prefix($prefix)
            ->group($routes);
    }


    public function registerMigration(
        array $paths
    ): void {

        $migrator = $this->app->make(
            Migrator::class
        );

        foreach ($paths as $path) {
            $migrator->path($path);
        }
    }


    public function registerCommand(
        string $command
    ): void {

        $this->app->make(
            'Illuminate\Contracts\Console\Kernel'
        )->resolveCommands([
            $command
        ]);
    }


    public function registerSchedule(
        callable $schedule
    ): void {

        $schedule(
            $this->app->make(
                Schedule::class
            )
        );
    }


    public function registerConfig(
        array $configuration
    ): void {

        config()->set(
            $configuration
        );
    }

    public function registerCommandHandler(
        string $command,
        string $handler,
    ): void {

        $this->app
            ->make(CommandRegistry::class)
            ->register(
                $command,
                $handler,
            );
    }
}
