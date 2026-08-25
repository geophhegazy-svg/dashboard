<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\Kernel\Contracts\KernelBootstrapperInterface;
use App\Core\Kernel\Contracts\KernelShutdownManagerInterface;
use App\Core\Kernel\Contracts\KernelCommandRegistrarInterface;

use App\Infrastructure\Laravel\Console\Kernel\KernelCacheCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelCacheClearCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelCacheStatusCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelDiagnosticsCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelHealthCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelModulesCommand;
use App\Infrastructure\Laravel\Console\Kernel\KernelValidateCommand;

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
                KernelCacheClearCommand::class,
                KernelCacheStatusCommand::class,
                KernelDiagnosticsCommand::class,
                KernelHealthCommand::class,
                KernelValidateCommand::class,
            ] as $command
        ) {
            $registrar->register($command);
        }

        $this->app->terminating(
            function (): void {
                $this->app
                    ->make(KernelShutdownManagerInterface::class)
                    ->shutdown();
            },
        );

        $this->app
            ->make(KernelBootstrapperInterface::class)
            ->boot();
    }
}
