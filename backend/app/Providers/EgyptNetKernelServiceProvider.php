<?php

declare(strict_types=1);

namespace App\Providers;

use App\Core\Contracts\ContainerInterface;
use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\EventBus\EventDispatcher;
use App\Core\EventBus\EventRegistry;
use App\Core\EventBus\Contracts\ListenerResolverInterface;

use App\Core\Kernel\Bootstrap\KernelBootstrapper;
use App\Core\Kernel\Contracts\KernelBootstrapperInterface;
use App\Core\Kernel\Contracts\KernelCommandRegistrarInterface;
use App\Core\Kernel\Contracts\KernelValidatorInterface;
use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Contracts\ModuleDiscoveryInterface;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;

use App\Core\Kernel\Compiler\CompiledManifestProvider;
use App\Core\Kernel\Compiler\ManifestCollector;
use App\Core\Kernel\Compiler\ModuleManifestCompiler;




use App\Core\Kernel\Fingerprint\ManifestFingerprintGenerator;

use App\Core\Kernel\Health\Checks\KernelBootCheck;
use App\Core\Kernel\Health\Checks\ManifestAvailabilityCheck;
use App\Core\Kernel\Health\KernelHealthService;

use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\Registration\LifecycleEventRegistrar;

use App\Core\Kernel\Monitoring\KernelBootTimeline;
use App\Core\Kernel\Monitoring\KernelMonitoringService;

use App\Core\Kernel\Registration\CompiledManifestRegistrationService;
use App\Core\Kernel\Registration\CompiledResourceRegistrar;
use App\Core\Kernel\Registration\ModuleRegistrationService;

use App\Core\Kernel\Registration\Handlers\ActionResourceHandler;
use App\Core\Kernel\Registration\Handlers\CommandHandlerResourceHandler;
use App\Core\Kernel\Registration\Handlers\ListenerResourceHandler;
use App\Core\Kernel\Registration\Handlers\QueryResourceHandler;
use App\Core\Kernel\Registration\Handlers\ServiceResourceHandler;
use App\Core\Kernel\Registration\Handlers\PolicyResourceHandler;

use App\Core\Kernel\Runtime\KernelRuntimeState;

use App\Core\Kernel\Validation\KernelValidator;

use App\Infrastructure\Laravel\Container\LaravelContainerAdapter;
use App\Infrastructure\Laravel\Console\Kernel\KernelCacheCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelCacheStatusCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelDiagnosticsCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelHealthCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelModulesCommand;

use App\Infrastructure\Laravel\EventBus\LaravelListenerResolver;

use App\Infrastructure\Laravel\Kernel\FileModuleManifestCache;
use App\Infrastructure\Laravel\Kernel\LaravelKernelCommandRegistrar;
use App\Infrastructure\Laravel\Kernel\LaravelModuleRegistrar;


use App\Core\Kernel\Validation\KernelValidationRuleRegistry;

use Illuminate\Support\ServiceProvider;


final class EgyptNetKernelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerKernelCore();

        $this->registerEventBus();

        $this->registerHealth();

        $this->registerInfrastructure();
    }


    private function registerKernelCore(): void
    {
        $this->app->bind(
            ModuleRegistrarInterface::class,
            LaravelModuleRegistrar::class,
        );


        $this->app->singleton(
            ModuleDiscoveryInterface::class,
            \App\Core\Kernel\Discovery\ModuleDiscovery::class,
        );


        $this->app->singleton(
            ModuleLoaderInterface::class,
            \App\Core\Kernel\Loader\ModuleLoader::class,
        );


        $this->app->singleton(
            KernelRuntimeState::class,
        );


        $this->app->singleton(
            KernelLifecycleManager::class,
        );


        $this->app->singleton(
            LifecycleEventRegistrar::class,
        );


        $this->app->singleton(
            KernelBootTimeline::class,
        );


        $this->app->singleton(
            \App\Core\ActionBus\ActionRegistry::class,
        );


        $this->app->singleton(
            \App\Core\QueryBus\QueryRegistry::class,
        );


        $this->app->singleton(
            \App\Core\ActionBus\ActionDispatcher::class,
        );


        $this->app->singleton(
            \App\Core\QueryBus\QueryDispatcher::class,
        );


        $this->app->singleton(
            KernelMonitoringService::class,
        );


        /*
    |--------------------------------------------------------------------------
    | Kernel Validation
    |--------------------------------------------------------------------------
    */

        $this->app->singleton(
            \App\Core\Kernel\Validation\DuplicateResourceDetector::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Extractors\ServiceExtractor::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Extractors\ActionExtractor::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Extractors\QueryExtractor::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Extractors\CommandExtractor::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Rules\CircularDependencyRule::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Rules\DuplicateModuleClassRule::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Rules\DuplicateModuleNameRule::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Rules\MissingDependencyRule::class,
        );


        $this->app->singleton(
            \App\Core\Kernel\Validation\Rules\DuplicateServiceRule::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Rules\DuplicateActionRule::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Rules\DuplicateQueryRule::class,
        );

        $this->app->singleton(
            \App\Core\Kernel\Validation\Rules\DuplicateCommandRule::class,
        );


        $this->app->singleton(
            KernelValidationRuleRegistry::class,
            fn($app) => new KernelValidationRuleRegistry(
                $app->make(ContainerInterface::class),
                [
                    \App\Core\Kernel\Validation\Rules\CircularDependencyRule::class,
                    \App\Core\Kernel\Validation\Rules\DuplicateModuleClassRule::class,
                    \App\Core\Kernel\Validation\Rules\DuplicateModuleNameRule::class,
                    \App\Core\Kernel\Validation\Rules\MissingDependencyRule::class,
                    \App\Core\Kernel\Validation\Rules\DuplicateServiceRule::class,
                    \App\Core\Kernel\Validation\Rules\DuplicateActionRule::class,
                    \App\Core\Kernel\Validation\Rules\DuplicateQueryRule::class,
                    \App\Core\Kernel\Validation\Rules\DuplicateCommandRule::class,
                ],
            ),
        );


        $this->app->singleton(
            KernelValidatorInterface::class,
            fn($app) => new KernelValidator(
                $app->make(KernelValidationRuleRegistry::class),
            ),
        );

        /*
    |--------------------------------------------------------------------------
    | Compiler
    |--------------------------------------------------------------------------
    */

        $this->app->singleton(
            ManifestCollector::class,
        );

        $this->app->singleton(
            ModuleManifestCompiler::class,
        );

        $this->app->singleton(
            CompiledManifestProvider::class,
        );


        /*
    |--------------------------------------------------------------------------
    | Registration Pipeline
    |--------------------------------------------------------------------------
    */

        $this->app->singleton(
            CompiledResourceRegistrar::class,
            fn() => new CompiledResourceRegistrar([
                new ServiceResourceHandler(),
                new ActionResourceHandler(),
                new QueryResourceHandler(),
                new ListenerResourceHandler(),
                new CommandHandlerResourceHandler(),
                new PolicyResourceHandler(),
            ]),
        );


        $this->app->singleton(
            CompiledManifestRegistrationService::class,
            function ($app) {
                return new CompiledManifestRegistrationService(
                    $app->make(CompiledResourceRegistrar::class),
                    $app->make(EventDispatcherInterface::class),
                );
            }
        );


        $this->app->singleton(
            ModuleRegistrationService::class,
        );


        /*
    |--------------------------------------------------------------------------
    | Bootstrapper
    |--------------------------------------------------------------------------
    */

        $this->app->singleton(
            KernelBootstrapperInterface::class,
            KernelBootstrapper::class,
        );
    }


    private function registerEventBus(): void
    {
        $this->app->singleton(
            EventRegistry::class,
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
    }


    private function registerHealth(): void
    {
        $this->app->singleton(
            KernelBootCheck::class,
        );


        $this->app->singleton(
            ManifestAvailabilityCheck::class,
        );


        $this->app->singleton(
            KernelHealthService::class,
            fn($app) => new KernelHealthService([
                $app->make(KernelBootCheck::class),
                $app->make(ManifestAvailabilityCheck::class),
            ]),
        );
    }


    private function registerInfrastructure(): void
    {
        $this->app->singleton(
            ModuleManifestCacheInterface::class,
            FileModuleManifestCache::class,
        );


        $this->app->singleton(
            ManifestFingerprintGeneratorInterface::class,
            ManifestFingerprintGenerator::class,
        );


        $this->app->singleton(
            KernelCommandRegistrarInterface::class,
            LaravelKernelCommandRegistrar::class,
        );


        $this->app->singleton(
            ContainerInterface::class,
            LaravelContainerAdapter::class,
        );
    }


    public function boot(): void
    {
        $commands = [
            KernelModulesCommand::class,
            KernelCacheCommand::class,
            KernelCacheStatusCommand::class,
            KernelDiagnosticsCommand::class,
            KernelHealthCommand::class,
        ];


        $registrar = $this->app
            ->make(KernelCommandRegistrarInterface::class);


        foreach ($commands as $command) {

            $registrar->register(
                $command,
            );
        }


        $this->app
            ->make(KernelBootstrapperInterface::class)
            ->boot();
    }
}
