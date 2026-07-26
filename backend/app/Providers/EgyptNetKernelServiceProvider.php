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
use App\Core\Kernel\Contracts\KernelCommandRegistrarInterface;
use App\Infrastructure\Laravel\Kernel\LaravelKernelCommandRegistrar;
use App\Infrastructure\Laravel\Console\Kernel\KernelCacheCommand;
use App\Core\Kernel\Registration\CompiledResourceRegistrar;
use App\Core\Kernel\Registration\Handlers\ServiceResourceHandler;
use App\Core\Kernel\Registration\CompiledManifestRegistrationService;
use App\Core\Kernel\Registration\Handlers\ActionResourceHandler;
use App\Core\Kernel\Registration\Handlers\QueryResourceHandler;
use App\Core\Kernel\Registration\Handlers\ListenerResourceHandler;
use App\Core\Kernel\Registration\Handlers\CommandHandlerResourceHandler;
use App\Core\Kernel\Diagnostics\KernelDiagnostics;
use App\Infrastructure\Laravel\Console\Kernel\KernelDiagnosticsCommand;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use App\Core\Kernel\Health\KernelHealthService;
use App\Core\Kernel\Health\Checks\KernelBootCheck;
use App\Core\Kernel\Health\Checks\ManifestAvailabilityCheck;
use App\Core\Kernel\Monitoring\KernelBootTimeline;
use App\Core\Kernel\Monitoring\KernelMonitoringService;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\Registration\LifecycleEventRegistrar;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
final class EgyptNetKernelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ModuleRegistrarInterface::class,
            LaravelModuleRegistrar::class,
        );

        $this->app->singleton(
            ManifestAvailabilityCheck::class,
        );

        $this->app->singleton(
            KernelBootCheck::class,
        );

        $this->app->singleton(
            KernelHealthService::class,
            fn($app) => new KernelHealthService([
                $app->make(KernelBootCheck::class),
                $app->make(ManifestAvailabilityCheck::class),
            ]),
        );

        $this->app->singleton(
            KernelRuntimeState::class,
        );

        $this->app->singleton(
            KernelLifecycleManager::class,
        );

        $this->app->singleton(
            KernelDiagnostics::class,
        );

        $this->app->singleton(
            KernelCommandRegistrarInterface::class,
            LaravelKernelCommandRegistrar::class,
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
            CompiledResourceRegistrar::class,
            fn() => new CompiledResourceRegistrar([
                new ServiceResourceHandler(),
                new ActionResourceHandler(),
                new QueryResourceHandler(),
                new ListenerResourceHandler(),
                new CommandHandlerResourceHandler(),
            ]),
        );

        $this->app->singleton(
            CompiledManifestRegistrationService::class,
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
            LifecycleEventRegistrar::class,
        );

        $this->app->singleton(
            ListenerResolverInterface::class,
            LaravelListenerResolver::class,
        );

        $this->app->singleton(
            EventDispatcherInterface::class,
            fn($app) => new EventDispatcher(
                $app->make(EventRegistry::class),
                $app->make(ListenerResolverInterface::class),
            ),
        );

        $this->app->alias(
            EventDispatcherInterface::class,
            EventDispatcher::class,
        );

        $this->app->singleton(
            KernelBootTimeline::class,
        );

        $this->app->singleton(
            KernelMonitoringService::class,
        );

        $this->app->singleton(
            \App\Core\Contracts\ContainerInterface::class,
            \App\Infrastructure\Laravel\Container\LaravelContainerAdapter::class,
        );
    }

    public function boot(): void
    {
        $commandRegistrar = $this->app
            ->make(KernelCommandRegistrarInterface::class);

        $commandRegistrar->register(
            \App\Infrastructure\Laravel\Console\Kernel\KernelModulesCommand::class,
        );

        $commandRegistrar->register(
            \App\Infrastructure\Laravel\Console\Kernel\KernelCacheCommand::class,
        );

        $commandRegistrar->register(
            \App\Infrastructure\Laravel\Console\Kernel\KernelCacheStatusCommand::class,
        );

        $commandRegistrar->register(
            KernelDiagnosticsCommand::class,
        );

        $this->app
            ->make(KernelBootstrapperInterface::class)
            ->boot();
    }
}
