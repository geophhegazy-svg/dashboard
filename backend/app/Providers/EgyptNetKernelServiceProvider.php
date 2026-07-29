<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\Kernel\Contracts\KernelBootstrapperInterface;
use App\Core\Kernel\Contracts\KernelCommandRegistrarInterface;

use App\Infrastructure\Laravel\Console\Kernel\KernelCacheCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelCacheStatusCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelDiagnosticsCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelHealthCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelModulesCommand;

final class EgyptNetKernelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(
            \App\Infrastructure\Laravel\Providers\KernelCoreServiceProvider::class
        );

        $this->app->register(
            \App\Infrastructure\Laravel\Providers\KernelValidationServiceProvider::class
        );

        $this->app->register(
            \App\Infrastructure\Laravel\Providers\KernelInfrastructureServiceProvider::class
        );

        $this->app->register(
            \App\Infrastructure\Laravel\Providers\KernelBusServiceProvider::class
        );

        $this->app->register(
            \App\Infrastructure\Laravel\Providers\KernelEventBusServiceProvider::class
        );

        $this->app->register(
            \App\Infrastructure\Laravel\Providers\KernelCompilerPipelineServiceProvider::class
        );

        $this->app->register(
            \App\Infrastructure\Laravel\Providers\KernelHealthServiceProvider::class
        );

        $this->app->register(
            \App\Infrastructure\Laravel\Providers\KernelBootstrapServiceProvider::class
        );
    }

    public function boot(): void
    {
        $registrar = $this->app->make(
            KernelCommandRegistrarInterface::class
        );

        foreach (
            [
                KernelModulesCommand::class,
                KernelCacheCommand::class,
                KernelCacheStatusCommand::class,
                KernelDiagnosticsCommand::class,
                KernelHealthCommand::class,
            ] as $command
        ) {
            $registrar->register($command);
        }

        $this->app
            ->make(KernelBootstrapperInterface::class)
            ->boot();
    }
}
