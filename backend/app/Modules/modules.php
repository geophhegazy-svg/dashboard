<?php

declare(strict_types=1);

use App\Modules\Accounting\Kernel\AccountingModule;
use App\Modules\Billing\Kernel\BillingModule;
use App\Modules\Subscription\Kernel\SubscriptionModule;

return [

    SubscriptionModule::class,

    BillingModule::class,

    AccountingModule::class,

];
