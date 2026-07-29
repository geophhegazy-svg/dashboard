<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\Contracts\ContainerInterface;

use App\Core\Kernel\Contracts\KernelCommandRegistrarInterface;
use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;

use App\Core\Kernel\Fingerprint\ManifestFingerprintGenerator;

use App\Infrastructure\Laravel\Container\LaravelContainerAdapter;
use App\Infrastructure\Laravel\Kernel\FileModuleManifestCache;
use App\Infrastructure\Laravel\Kernel\LaravelKernelCommandRegistrar;

final class KernelInfrastructureServiceProvider extends ServiceProvider
{
    public function register(): void
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
}
