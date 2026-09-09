<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Actions;

use App\Core\EventBus\Contracts\EventDispatcherInterface;
use App\Modules\Subscription\Domain\Contracts\HotspotSubscriptionRepositoryInterface;
use App\Modules\Subscription\Domain\Events\HotspotSubscriptionSuspended;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;

final readonly class SuspendHotspotSubscriptionAction
{
    public function __construct(
        private HotspotSubscriptionRepositoryInterface $repository,
        private EventDispatcherInterface $events,
    ) {}

    public function execute(
        HotspotSubscription $subscription
    ): HotspotSubscription {
        $subscription = $this->repository->update(
            $subscription,
            ['status' => 'suspended']
        );

        $this->events->dispatch(
            new HotspotSubscriptionSuspended(
                $subscription
            )
        );

        return $subscription;
    }
}
