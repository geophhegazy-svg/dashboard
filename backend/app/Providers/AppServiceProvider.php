<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Modules\Finance\Domain\Contracts\FinanceServiceInterface;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;

use App\Modules\Accounting\Domain\Contracts\AccountRepositoryInterface;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Task\Domain\Contracts\TaskRepositoryInterface;
use App\Modules\Reports\Domain\Contracts\ReportRepositoryInterface;
use App\Modules\Reports\Domain\Contracts\ReportExportRepositoryInterface;
use App\Modules\Reports\Domain\Contracts\ScheduledReportRepositoryInterface;
use App\Modules\Accounting\Domain\Contracts\JournalEntryRepositoryInterface;
use App\Modules\Accounting\Domain\Contracts\JournalEntryLineRepositoryInterface;

use App\Modules\Accounting\Infrastructure\Repositories\AccountRepository;
use App\Modules\Subscription\Infrastructure\Repositories\SubscriptionRepository;
use App\Modules\Task\Infrastructure\Repositories\TaskRepository;
use App\Modules\Reports\Infrastructure\Repositories\ReportRepository;
use App\Modules\Reports\Infrastructure\Repositories\ReportExportRepository;
use App\Modules\Reports\Infrastructure\Repositories\ScheduledReportRepository;
use App\Modules\Accounting\Infrastructure\Repositories\JournalEntryRepository;
use App\Modules\Accounting\Infrastructure\Repositories\JournalEntryLineRepository;

use App\Modules\Finance\Application\Services\FinanceService;
use App\Modules\Network\Application\MikrotikServiceAdapter;

use App\Modules\Accounting\Application\Services\JournalEntryNumberService;
use App\Modules\Accounting\Application\Services\JournalPostingService;
use App\Modules\Accounting\Application\Services\JournalValidationService;
use App\Core\Kernel\Discovery\Contracts\ModuleSourceInterface;
use App\Infrastructure\Laravel\Discovery\LaravelModuleSource;
use App\Core\Kernel\Discovery\Contracts\PluginSourceInterface;
use App\Infrastructure\Laravel\Discovery\LaravelPluginSource;

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
            SubscriptionRepositoryInterface::class,
            SubscriptionRepository::class
        );

        $this->app->bind(
            AccountRepositoryInterface::class,
            AccountRepository::class
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

        $this->app->bind(
            PluginSourceInterface::class,
            LaravelPluginSource::class,
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

        $this->app->bind(
            ModuleSourceInterface::class,
            LaravelModuleSource::class,
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
            \App\Core\EventBus\Bridge\EventBridge::class
        );
    }
}
