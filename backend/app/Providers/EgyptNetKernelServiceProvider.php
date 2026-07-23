<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\EventBus\EventRegistry;
use App\Core\EventBus\EventDispatcher;
use App\Core\EventBus\Contracts\ListenerResolverInterface;
use App\Infrastructure\Laravel\EventBus\LaravelListenerResolver;
use App\Core\ActionBus\ActionRegistry;
use App\Core\ActionBus\ActionDispatcher;
use App\Core\ActionBus\Pipeline\ActionPipeline;
use App\Core\QueryBus\QueryRegistry;
use App\Core\QueryBus\QueryDispatcher;
use App\Core\CommandBus\CommandRegistry;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Infrastructure\Laravel\Kernel\LaravelModuleRegistrar;
use App\Core\CommandBus\CommandDispatcher;
use App\Core\Kernel\Compiler\ModuleManifestCompiler;

class EgyptNetKernelServiceProvider extends ServiceProvider
{

    public function register(): void
    {

        $this->app->bind(
            ModuleRegistrarInterface::class,
            LaravelModuleRegistrar::class
        );

        $this->app->singleton(
            ModuleManifestCompiler::class,
        );

        $this->app->singleton(
            CommandDispatcher::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Contracts\ModuleDiscoveryInterface::class,
            \App\Core\Kernel\Discovery\ModuleDiscovery::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\DependencyResolver::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Contracts\KernelBootstrapperInterface::class,
            \App\Core\Kernel\Bootstrap\KernelBootstrapper::class,
        );

        $this->app->singleton(
            CommandRegistry::class,
            fn() => new CommandRegistry(),
        );

        $this->app->singleton(
            QueryRegistry::class,
        );

        $this->app->singleton(
            QueryDispatcher::class,
        );

        $this->app->singleton(
            ActionRegistry::class,
            fn() => new ActionRegistry(),
        );

        $this->app->singleton(
            ActionPipeline::class,
            fn() => new ActionPipeline(),
        );

        $this->app->singleton(
            ActionDispatcher::class,
            fn($app) => new ActionDispatcher(
                $app->make(ActionRegistry::class),
                $app->make(ActionPipeline::class),
            ),
        );

        $this->app->singleton(
            \App\Core\Kernel\ModuleRegistry::class,
            function ($app) {
                return new \App\Core\Kernel\ModuleRegistry(
                    $app->make(ModuleRegistrarInterface::class)
                );
            }
        );

        $this->app->singleton(
            \App\Core\Kernel\EgyptNetKernel::class,
            function ($app) {
                return new \App\Core\Kernel\EgyptNetKernel(
                    $app->make(ModuleRegistrarInterface::class)
                );
            }
        );

        $this->app->singleton(
            EventRegistry::class,
            function () {
                return new EventRegistry();
            }
        );

        $this->app->singleton(
            ListenerResolverInterface::class,
            LaravelListenerResolver::class,
        );


        $this->app->singleton(
            EventDispatcher::class,
            fn($app) => new EventDispatcher(
                $app->make(EventRegistry::class),
                $app->make(ListenerResolverInterface::class),
            ),
        );

    }


    public function boot(): void
    {
        $this->app
            ->make(
                \App\Core\Kernel\Contracts\KernelBootstrapperInterface::class
            )
            ->boot();
    }
}
