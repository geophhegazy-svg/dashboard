<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;

use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Core\EventBus\Contracts\ListenerResolverInterface;
use App\Core\EventBus\EventDispatcher;
use App\Core\EventBus\EventRegistry;

use App\Infrastructure\Laravel\EventBus\LaravelListenerResolver;

final class KernelEventBusServiceProvider extends ServiceProvider
{
    public function register(): void
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
}
