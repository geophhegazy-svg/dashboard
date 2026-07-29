<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\Kernel\Health\Checks\KernelBootCheck;
use App\Core\Kernel\Health\Checks\ManifestAvailabilityCheck;
use App\Core\Kernel\Health\KernelHealthService;

final class KernelHealthServiceProvider extends ServiceProvider
{
    public function register(): void
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
}
