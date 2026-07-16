<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\FinanceServiceInterface;
use App\Contracts\MikrotikServiceInterface;

use App\Contracts\Repositories\AccountRepositoryInterface;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Contracts\Repositories\ReportExportRepositoryInterface;
use App\Contracts\Repositories\ScheduledReportRepositoryInterface;
use App\Contracts\Repositories\JournalEntryRepositoryInterface;
use App\Contracts\Repositories\JournalEntryLineRepositoryInterface;

use App\Repositories\Eloquent\AccountRepository;
use App\Modules\Subscription\Infrastructure\Repositories\SubscriptionRepository;
use App\Repositories\Eloquent\TaskRepository;
use App\Repositories\Eloquent\ReportRepository;
use App\Repositories\Eloquent\ReportExportRepository;
use App\Repositories\Eloquent\ScheduledReportRepository;
use App\Repositories\Eloquent\JournalEntryRepository;
use App\Repositories\Eloquent\JournalEntryLineRepository;

use App\Services\Finance\FinanceService;
use App\Services\Network\MikrotikServiceAdapter;

use App\Services\Finance\JournalEntryNumberService;
use App\Services\Accounting\JournalPostingService;
use App\Services\Accounting\JournalValidationService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Repositories
        |--------------------------------------------------------------------------
        */

        $this->app->bind(
            AccountRepositoryInterface::class,
            AccountRepository::class
        );

        $this->app->bind(
            SubscriptionRepositoryInterface::class,
            SubscriptionRepository::class
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

        $this->app->bind(
            JournalEntryRepositoryInterface::class,
            JournalEntryRepository::class
        );

        $this->app->bind(
            JournalEntryLineRepositoryInterface::class,
            JournalEntryLineRepository::class
        );

        /*
        |--------------------------------------------------------------------------
        | Core Services
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            FinanceServiceInterface::class,
            FinanceService::class
        );

        $this->app->bind(
            MikrotikServiceInterface::class,
            MikrotikServiceAdapter::class
        );

        /*
        |--------------------------------------------------------------------------
        | Accounting Services
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            JournalEntryNumberService::class
        );

        $this->app->singleton(
            JournalValidationService::class
        );

        $this->app->singleton(
            JournalPostingService::class
        );
    }

    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(
            \App\Core\EventBus\Contracts\EventContract::class,
            \App\Core\EventBus\Bridge\LaravelEventBridge::class
        );
    }
}
