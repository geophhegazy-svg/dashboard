<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Events;

use App\Core\EventBus\Contracts\EventContract;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionActivated implements EventContract
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public readonly Subscription $subscription
    ) {}
}
