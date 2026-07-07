<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\MikrotikServiceInterface;
use App\Services\Network\MikroTikService;
use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Repositories\SubscriptionRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            MikrotikServiceInterface::class,
            MikroTikService::class
        );

        $this->app->bind(
            SubscriptionRepositoryInterface::class,
            SubscriptionRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
