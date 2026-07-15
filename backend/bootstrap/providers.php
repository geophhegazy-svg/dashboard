<?php

return [

    App\Providers\AppServiceProvider::class,

    App\Providers\EgyptNetKernelServiceProvider::class,

    App\Providers\ReportsServiceProvider::class,

    App\Providers\NetworkServiceProvider::class,

    App\Modules\Subscription\Infrastructure\Providers\SubscriptionEventServiceProvider::class,
    
];
