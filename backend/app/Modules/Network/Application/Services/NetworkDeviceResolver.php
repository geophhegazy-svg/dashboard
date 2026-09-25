<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Services;

use App\Modules\Network\Application\Contracts\NetworkDeviceResolverInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use RuntimeException;

final class NetworkDeviceResolver implements NetworkDeviceResolverInterface
{
    public function resolveForSubscription(
        Subscription $subscription
    ): ?NetworkDevice {
        $devices = NetworkDevice::query()
            ->where('status', 'active')
            ->where('type', 'mikrotik')
            ->whereNull('tenant_id')
            ->get();

        if ($devices->isEmpty()) {
            return null;
        }

        if ($devices->count() > 1) {
            throw new RuntimeException(
                'Multiple active global MikroTik network devices are configured.'
            );
        }

        return $devices->first();
    }
}
