<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Network\Providers\MikroTik\MikroTikConnectionService;
use App\Services\Network\Providers\MikroTik\MikroTikQueryService;
use App\Services\Network\Providers\MikroTik\MikroTikPppoeService;
use App\Services\Network\Providers\MikroTik\MikroTikQueueService;
use App\Services\Network\Providers\MikroTik\MikroTikHotspotService;
use App\Services\Network\Providers\MikroTik\MikroTikFirewallService;
use App\Services\Network\Providers\MikroTik\MikroTikDhcpService;
use App\Services\Network\Providers\MikroTik\MikroTikMonitoringService;
use App\Contracts\Network\NetworkProviderInterface;
use App\Services\Network\NetworkProviderResolver;
use App\Services\Network\Providers\MikroTik\MikroTikProvider;


class NetworkServiceProvider extends ServiceProvider
{
    /**
     * Register network services.
     */
    public function register(): void
    {
        $this->app->bind(
            NetworkProviderInterface::class,
            function ($app) {

                return $app->make(
                    MikroTikProvider::class
                );
            }
        );

        $this->app->singleton(
            NetworkProviderResolver::class,
            fn() => new NetworkProviderResolver()
        );

        /*
        |--------------------------------------------------------------------------
        | MikroTik Connection
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            MikroTikConnectionService::class,
            function () {

                return new MikroTikConnectionService();
            }
        );



        /*
        |--------------------------------------------------------------------------
        | MikroTik Query Layer
        |--------------------------------------------------------------------------
        */

        $this->app->singleton(
            MikroTikQueryService::class,
            function ($app) {

                return new MikroTikQueryService(
                    $app->make(
                        MikroTikConnectionService::class
                    )
                );
            }
        );



        /*
        |--------------------------------------------------------------------------
        | MikroTik Domain Services
        |--------------------------------------------------------------------------
        */


        $this->app->singleton(
            MikroTikPppoeService::class,
            fn($app) =>
            new MikroTikPppoeService(
                $app->make(
                    MikroTikQueryService::class
                )
            )
        );



        $this->app->singleton(
            MikroTikQueueService::class,
            fn($app) =>
            new MikroTikQueueService(
                $app->make(
                    MikroTikQueryService::class
                )
            )
        );



        $this->app->singleton(
            MikroTikHotspotService::class,
            fn($app) =>
            new MikroTikHotspotService(
                $app->make(
                    MikroTikQueryService::class
                )
            )
        );



        $this->app->singleton(
            MikroTikFirewallService::class,
            fn($app) =>
            new MikroTikFirewallService(
                $app->make(
                    MikroTikQueryService::class
                )
            )
        );



        $this->app->singleton(
            MikroTikDhcpService::class,
            fn($app) =>
            new MikroTikDhcpService(
                $app->make(
                    MikroTikQueryService::class
                )
            )
        );



        $this->app->singleton(
            MikroTikMonitoringService::class,
            fn($app) =>
            new MikroTikMonitoringService(
                $app->make(
                    MikroTikQueryService::class
                )
            )
        );

    }



    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
