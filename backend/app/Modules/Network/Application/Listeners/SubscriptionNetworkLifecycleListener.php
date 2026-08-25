<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Listeners;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Domain\Events\SubscriptionExpired;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;
use App\Modules\Subscription\Domain\Events\SubscriptionRestored;
use App\Modules\Subscription\Domain\Events\SubscriptionSuspended;

final readonly class SubscriptionNetworkLifecycleListener implements EventListenerInterface
{
    public function __construct(
        private MikrotikServiceInterface $mikrotik,
    ) {}

    public function handle(EventContract $event): void
    {
        $subscription = $event->subscription;

        if (empty($subscription->pppoe_username)) {
            return;
        }

        if (
            $event instanceof SubscriptionActivated
            || $event instanceof SubscriptionRestored
            || $event instanceof SubscriptionRenewed
        ) {
            $this->mikrotik->enableUser(
                $subscription->pppoe_username
            );

            return;
        }

        if (
            $event instanceof SubscriptionSuspended
            || $event instanceof SubscriptionExpired
        ) {
            $this->mikrotik->disableUser(
                $subscription->pppoe_username
            );
        }
    }
}
