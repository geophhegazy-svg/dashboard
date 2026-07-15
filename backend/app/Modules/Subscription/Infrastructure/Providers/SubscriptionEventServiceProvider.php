<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Application\Listeners\EnableMikrotikUserListener;

final class SubscriptionEventServiceProvider extends EventServiceProvider
{
    protected $listen = [

        SubscriptionActivated::class => [

            EnableMikrotikUserListener::class,

        ],

    ];
}
