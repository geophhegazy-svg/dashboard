<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\Kernel\Bootstrap\KernelBootstrapper;
use App\Core\Kernel\Contracts\KernelBootstrapperInterface;

final class KernelBootstrapServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            KernelBootstrapperInterface::class,
            KernelBootstrapper::class,
        );
    }
}
