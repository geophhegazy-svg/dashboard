<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Listeners;

use App\Modules\Network\Domain\Contracts\MikrotikServiceInterface;
use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Modules\Subscription\Domain\Events\SubscriptionActivated;
use App\Modules\Subscription\Domain\Events\SubscriptionRestored;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;

final readonly class EnableMikrotikUserListener implements EventListenerInterface
{
    public function __construct(
        private MikrotikServiceInterface $mikrotik,
    ) {}

    public function handle(
        EventContract $event
    ): void {

        if (
            ! $event instanceof SubscriptionActivated
            && ! $event instanceof SubscriptionRestored
            && ! $event instanceof SubscriptionRenewed
        ) {
            return;
        }

        $subscription = $event->subscription;

        if (empty($subscription->pppoe_username)) {
            return;
        }

        $this->mikrotik->enableUser(
            $subscription->pppoe_username
        );
    }
}
