<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Listeners;

use App\Exceptions\Network\MikroTikException;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Subscription\Domain\Events\HotspotSubscriptionActivated;
use App\Modules\Subscription\Domain\Events\HotspotSubscriptionSuspended;

final readonly class HotspotSubscriptionNetworkLifecycleListener
    implements EventListenerInterface
{
    public function __construct(
        private HotspotServiceInterface $hotspot,
    ) {}

    public function handle(EventContract $event): void
    {
        if (
            ! $event instanceof HotspotSubscriptionActivated
            && ! $event instanceof HotspotSubscriptionSuspended
        ) {
            return;
        }

        $subscription = $event->subscription;

        if (empty($subscription->hotspot_username)) {
            return;
        }

        if ($event instanceof HotspotSubscriptionActivated) {
            $username = $subscription->hotspot_username;

            $existingUser = $this->hotspot->findUser($username);

            if ($existingUser === null) {
                if (
                    empty($subscription->hotspot_password)
                    || empty($subscription->mikrotik_profile)
                ) {
                    throw new MikroTikException(
                        'Hotspot subscription credentials are incomplete.',
                        500,
                        null,
                        [
                            'username' => $username,
                            'event' => $event::class,
                        ],
                    );
                }

                if (! $this->hotspot->createUser(
                    $username,
                    $subscription->hotspot_password,
                    $subscription->mikrotik_profile,
                )) {
                    throw new MikroTikException(
                        'Failed to create Hotspot user on MikroTik.',
                        500,
                        null,
                        [
                            'username' => $username,
                            'event' => $event::class,
                        ],
                    );
                }
            }

            if (! $this->hotspot->enableUser($username)) {
                throw new MikroTikException(
                    'Failed to enable Hotspot user on MikroTik.',
                    500,
                    null,
                    [
                        'username' => $username,
                        'event' => $event::class,
                    ],
                );
            }

            return;
        }

        if (! $this->hotspot->disableUser(
            $subscription->hotspot_username
        )) {
            throw new MikroTikException(
                'Failed to disable Hotspot user on MikroTik.',
                500,
                null,
                [
                    'username' => $subscription->hotspot_username,
                    'event' => $event::class,
                ],
            );
        }
    }
}
