<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\MikrotikServiceInterface;
use App\Services\Network\MikrotikService;
use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Repositories\SubscriptionRepository;
use App\Contracts\FinanceServiceInterface;
use App\Services\Finance\FinanceService;
use App\Contracts\Repositories\AccountRepositoryInterface;
use App\Repositories\AccountRepository;
use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Repositories\Eloquent\TaskRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AccountRepositoryInterface::class,
            AccountRepository::class
        );

        $this->app->bind(
            MikrotikServiceInterface::class,
            MikrotikService::class
        );

        $this->app->bind(
            SubscriptionRepositoryInterface::class,
            SubscriptionRepository::class
        );

        $this->app->singleton(
            FinanceServiceInterface::class,
            FinanceService::class
        );

        $this->app->bind(
            TaskRepositoryInterface::class,
            TaskRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
