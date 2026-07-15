<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\EgyptNetKernel;
use App\Modules\Subscription\Kernel\SubscriptionModule;
use App\Core\Kernel\Discovery\ModuleDiscovery;
use App\Core\EventBus\EventRegistry;
use App\Core\EventBus\EventDispatcher;

class EgyptNetKernelServiceProvider extends ServiceProvider
{

    public function register(): void
    {

        $this->app->singleton(
            ModuleRegistry::class,
            function () {
                return new ModuleRegistry();
            }
        );


        $this->app->singleton(
            EgyptNetKernel::class,
            function ($app) {

                return new EgyptNetKernel(
                    $app->make(ModuleRegistry::class)
                );
            }
        );

        $this->app->singleton(
            EventRegistry::class,
            function () {
                return new EventRegistry();
            }
        );


        $this->app->singleton(
            EventDispatcher::class,
            function ($app) {

                return new EventDispatcher(
                    $app->make(EventRegistry::class)
                );
            }
        );
    }


    public function boot(): void
    {
        $kernel = $this->app
            ->make(EgyptNetKernel::class);


        $discovery = new ModuleDiscovery();


        foreach ($discovery->discover() as $module) {

            $kernel->modules()
                ->register($module);
        }


        $kernel->boot();
    }
}
