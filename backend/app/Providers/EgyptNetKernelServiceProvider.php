<?php

declare(strict_types=1);

namespace App\Providers;

use App\Core\ActionBus\ActionDispatcher;
use App\Core\ActionBus\ActionRegistry;
use App\Core\ActionBus\Pipeline\ActionPipeline;
use App\Core\CommandBus\CommandDispatcher;
use App\Core\CommandBus\CommandRegistry;
use App\Core\EventBus\Contracts\ListenerResolverInterface;
use App\Core\EventBus\EventDispatcher;
use App\Core\EventBus\EventRegistry;
use App\Core\Kernel\Compiler\ModuleManifestCompiler;
use App\Core\Kernel\Contracts\KernelBootstrapperInterface;
use App\Core\Kernel\Contracts\ModuleDiscoveryInterface;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\KernelValidatorInterface;
use App\Core\Kernel\Validation\KernelValidator;
use App\Core\Kernel\Validation\Rules\CircularDependencyRule;
use App\Core\Kernel\Validation\Rules\DuplicateModuleClassRule;
use App\Core\Kernel\Validation\Rules\DuplicateModuleNameRule;
use App\Core\Kernel\Validation\Rules\MissingDependencyRule;
use App\Core\Kernel\Bootstrap\KernelBootstrapper;
use App\Core\Kernel\Discovery\ModuleDiscovery;
use App\Core\Kernel\Loader\ModuleLoader;
use App\Core\Kernel\ModuleRegistry;
use App\Core\QueryBus\QueryDispatcher;
use App\Core\QueryBus\QueryRegistry;
use App\Infrastructure\Laravel\EventBus\LaravelListenerResolver;
use App\Infrastructure\Laravel\Kernel\LaravelModuleRegistrar;
use Illuminate\Support\ServiceProvider;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Infrastructure\Laravel\Kernel\FileModuleManifestCache;
use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Fingerprint\ManifestFingerprintGenerator;
use App\Core\Kernel\Compiler\CompiledManifestProvider;
use App\Core\Kernel\Registration\ModuleRegistrationService;


final class EgyptNetKernelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ModuleRegistrarInterface::class,
            LaravelModuleRegistrar::class,
        );

        $this->app->singleton(
            ManifestFingerprintGeneratorInterface::class,
            ManifestFingerprintGenerator::class,
        );

        $this->app->singleton(
            ModuleManifestCacheInterface::class,
            FileModuleManifestCache::class,
        );

        $this->app->singleton(
            ModuleManifestCompiler::class,
        );

        $this->app->singleton(
            CompiledManifestProvider::class,
        );

        $this->app->singleton(
            ModuleDiscoveryInterface::class,
            ModuleDiscovery::class,
        );

        $this->app->singleton(
            ModuleRegistry::class,
        );

        $this->app->singleton(
            ModuleLoaderInterface::class,
            ModuleLoader::class,
        );

        $this->app->singleton(
            ModuleRegistrationService::class,
        );

        $this->app->singleton(
            KernelValidatorInterface::class,
            fn($app) => new KernelValidator([
                $app->make(CircularDependencyRule::class),
                $app->make(DuplicateModuleClassRule::class),
                $app->make(DuplicateModuleNameRule::class),
                $app->make(MissingDependencyRule::class),
            ]),
        );

        $this->app->singleton(
            KernelBootstrapperInterface::class,
            KernelBootstrapper::class,
        );

        $this->app->singleton(
            CommandRegistry::class,
            fn() => new CommandRegistry(),
        );

        $this->app->singleton(
            CommandDispatcher::class,
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
            EventRegistry::class,
            fn() => new EventRegistry(),
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
            ->make(KernelBootstrapperInterface::class)
            ->boot();
    }
}
