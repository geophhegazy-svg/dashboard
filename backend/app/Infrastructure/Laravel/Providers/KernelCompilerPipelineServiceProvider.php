<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\Contracts\ContainerInterface;
use App\Core\EventBus\Contracts\EventDispatcherInterface;

use App\Core\Kernel\Compiler\CompiledManifestProvider;
use App\Core\Kernel\Compiler\ManifestCollector;
use App\Core\Kernel\Compiler\ModuleManifestCompiler;

use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;

use App\Core\Kernel\Fingerprint\ManifestFingerprintGenerator;

use App\Core\Kernel\Registration\CompiledManifestRegistrationService;
use App\Core\Kernel\Registration\CompiledResourceRegistrar;

use App\Core\Kernel\Registration\Handlers\ActionResourceHandler;
use App\Core\Kernel\Registration\Handlers\CommandHandlerResourceHandler;
use App\Core\Kernel\Registration\Handlers\ListenerResourceHandler;
use App\Core\Kernel\Registration\Handlers\PolicyResourceHandler;
use App\Core\Kernel\Registration\Handlers\QueryResourceHandler;
use App\Core\Kernel\Registration\Handlers\ServiceResourceHandler;
use App\Core\Kernel\Registration\Handlers\SingletonResourceHandler;

use App\Infrastructure\Laravel\Kernel\FileModuleManifestCache;

final class KernelCompilerPipelineServiceProvider extends ServiceProvider
{
    public function register(): void
    {
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
        | Resource Registration
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            CompiledResourceRegistrar::class,
            fn() => new CompiledResourceRegistrar([
                new ServiceResourceHandler(),
                new SingletonResourceHandler(),
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
                    $app->make(ContainerInterface::class),
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Manifest Cache
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            ModuleManifestCacheInterface::class,
            FileModuleManifestCache::class,
        );

        $this->app->singleton(
            ManifestFingerprintGeneratorInterface::class,
            ManifestFingerprintGenerator::class,
        );
    }
}
