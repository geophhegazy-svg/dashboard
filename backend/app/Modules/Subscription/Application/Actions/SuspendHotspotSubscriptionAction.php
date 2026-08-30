<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Actions;

use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Subscription\Domain\Contracts\HotspotSubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;

final readonly class SuspendHotspotSubscriptionAction
{
    public function __construct(
        private HotspotSubscriptionRepositoryInterface $repository,
        private HotspotServiceInterface $hotspot,
    ) {}

    public function execute(
        HotspotSubscription $subscription,
    ): HotspotSubscription {

        $this->hotspot->disableUser(
            $subscription->hotspot_username
        );

        return $this->repository->update(
            $subscription,
            [
                'status' => 'suspended',
            ]
        );
    }
}
