<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\EventBus\Contracts\ListenerResolverInterface;
use App\Infrastructure\Laravel\EventBus\LaravelListenerResolver;

class PlatformServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ListenerResolverInterface::class,
            LaravelListenerResolver::class,
        );
    }

    public function boot(): void
    {
        //
    }
}
