<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\FinanceServiceInterface;
use App\Contracts\MikrotikServiceInterface;

use App\Contracts\Repositories\AccountRepositoryInterface;
use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Contracts\Repositories\ReportExportRepositoryInterface;
use App\Contracts\Repositories\ScheduledReportRepositoryInterface;

use App\Repositories\AccountRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\ReportRepository;
use App\Repositories\ReportExportRepository;
use App\Repositories\ScheduledReportRepository;
use App\Repositories\Eloquent\TaskRepository;

use App\Services\Finance\FinanceService;
use App\Services\Network\MikrotikService;

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

        $this->app->bind(
            ReportRepositoryInterface::class,
            ReportRepository::class
        );

        $this->app->bind(
            ReportExportRepositoryInterface::class,
            ReportExportRepository::class
        );

        $this->app->bind(
            ScheduledReportRepositoryInterface::class,
            ScheduledReportRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
