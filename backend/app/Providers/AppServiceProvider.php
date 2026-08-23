<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


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
    }

}
