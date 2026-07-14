<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Events;

use App\Models\HotspotSubscription;
use App\Models\Subscription;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionExpired
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Subscription|HotspotSubscription $subscription,
    ) {}
}
