<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\ActionBus\ActionDispatcher;
use App\Core\ActionBus\ActionRegistry;

use App\Core\QueryBus\QueryDispatcher;
use App\Core\QueryBus\QueryRegistry;

final class KernelBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ActionRegistry::class,
        );

        $this->app->singleton(
            QueryRegistry::class,
        );

        $this->app->singleton(
            ActionDispatcher::class,
        );

        $this->app->singleton(
            QueryDispatcher::class,
        );
    }
}
