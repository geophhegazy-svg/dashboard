<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Reports\Domain\Contracts\ReportRepositoryInterface;
use App\Modules\Reports\Domain\Contracts\ReportExportRepositoryInterface;
use App\Modules\Reports\Domain\Contracts\ScheduledReportRepositoryInterface;

use App\Modules\Reports\Infrastructure\Repositories\ReportRepository;
use App\Modules\Reports\Infrastructure\Repositories\ReportExportRepository;
use App\Modules\Reports\Infrastructure\Repositories\ScheduledReportRepository;

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
            PluginSourceInterface::class,
            LaravelPluginSource::class,
        );

        /*
        |--------------------------------------------------------------------------
        | Core Services
        |--------------------------------------------------------------------------
        */

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
