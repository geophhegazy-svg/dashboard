<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Listeners;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Exceptions\Network\MikroTikException;
use App\Modules\Network\Application\Contracts\NetworkDeviceResolverInterface;
use App\Modules\Network\Application\Contracts\NetworkManagerInterface;
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
        private NetworkDeviceResolverInterface $deviceResolver,
        private NetworkManagerInterface $networkManager,
    ) {}

    public function handle(EventContract $event): void
    {
        $subscription = $event->subscription;

        if (empty($subscription->pppoe_username)) {
            return;
        }

        $device = $this->deviceResolver->resolveForSubscription($subscription);

        if ($device === null) {
            throw new MikroTikException(
                'No active MikroTik network device is configured for subscription lifecycle operation.',
                500,
                null,
                [
                    'subscription_id' => $subscription->id,
                    'tenant_id' => $subscription->tenant_id,
                    'username' => $subscription->pppoe_username,
                    'event' => $event::class,
                ],
            );
        }

        if (! $this->networkManager->connect($device->id)) {
            throw new MikroTikException(
                'Failed to connect to MikroTik network device for subscription lifecycle operation.',
                500,
                null,
                [
                    'subscription_id' => $subscription->id,
                    'tenant_id' => $subscription->tenant_id,
                    'device_id' => $device->id,
                    'device_ip' => $device->ip_address,
                    'username' => $subscription->pppoe_username,
                    'event' => $event::class,
                ],
            );
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
                        'subscription_id' => $subscription->id,
                        'device_id' => $device->id,
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
                        'subscription_id' => $subscription->id,
                        'device_id' => $device->id,
                        'username' => $subscription->pppoe_username,
                        'event' => $event::class,
                    ],
                );
            }

            return;
        }

        if ($event instanceof SubscriptionExpired) {
            try {
                if (! $this->mikrotik->disableUser(
                    $subscription->pppoe_username
                )) {
                    throw new MikroTikException(
                        'Failed to disable expired PPPoE user on MikroTik.',
                        500,
                        null,
                        [
                            'subscription_id' => $subscription->id,
                            'device_id' => $device->id,
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
                            'subscription_id' => $subscription->id,
                            'device_id' => $device->id,
                            'username' => $subscription->pppoe_username,
                            'event' => $event::class,
                        ],
                    );
                }
            } catch (\App\Exceptions\Network\ResourceNotFoundException $e) {
                \Illuminate\Support\Facades\Log::warning(
                    'Expired subscription PPPoE user already absent on MikroTik.',
                    [
                        'subscription_id' => $subscription->id,
                        'device_id' => $device->id,
                        'username' => $subscription->pppoe_username,
                        'event' => $event::class,
                        'resource' => 'pppoe-user',
                    ],
                );
            }
        }
    }
}
