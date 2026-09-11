<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Listeners;

use App\Exceptions\Network\MikroTikException;

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
            if (! $this->mikrotik->enableUser(
                $subscription->pppoe_username
            )) {
                throw new MikroTikException(
                    'Failed to enable PPPoE user on MikroTik.',
                    500,
                    null,
                    [
                        'username' => $subscription->pppoe_username,
                        'event' => $event::class,
                    ],
                );
            }

            return;
        }

        if ($event instanceof SubscriptionSuspended) {
            if (! $this->mikrotik->disableUser(
                $subscription->pppoe_username
            )) {
                throw new MikroTikException(
                    'Failed to disable PPPoE user on MikroTik.',
                    500,
                    null,
                    [
                        'username' => $subscription->pppoe_username,
                        'event' => $event::class,
                    ],
                );
            }

            return;
        }

        if ($event instanceof SubscriptionExpired) {
            if (! $this->mikrotik->disableUser(
                $subscription->pppoe_username
            )) {
                throw new MikroTikException(
                    'Failed to disable expired PPPoE user on MikroTik.',
                    500,
                    null,
                    [
                        'username' => $subscription->pppoe_username,
                        'event' => $event::class,
                    ],
                );
            }

            if (! $this->mikrotik->disconnectUser(
                $subscription->pppoe_username
            )) {
                throw new MikroTikException(
                    'Failed to disconnect expired PPPoE user from MikroTik.',
                    500,
                    null,
                    [
                        'username' => $subscription->pppoe_username,
                        'event' => $event::class,
                    ],
                );
            }
        }
    }
}
