<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


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

}
