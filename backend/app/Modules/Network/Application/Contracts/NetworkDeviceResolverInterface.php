<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Contracts;

use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

interface NetworkDeviceResolverInterface
{
    public function resolveForSubscription(
        Subscription $subscription
    ): ?NetworkDevice;
}
