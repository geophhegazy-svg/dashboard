<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Contracts\ModuleDiscoveryInterface;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;

use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\Registration\LifecycleEventRegistrar;

use App\Core\Kernel\Monitoring\KernelBootTimeline;
use App\Core\Kernel\Monitoring\KernelMonitoringService;

use App\Core\Kernel\Runtime\KernelRuntimeState;

use App\Infrastructure\Laravel\Kernel\LaravelModuleRegistrar;

final class KernelCoreServiceProvider extends ServiceProvider
{
    public function register(): void
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
            KernelMonitoringService::class,
        );
    }
}
