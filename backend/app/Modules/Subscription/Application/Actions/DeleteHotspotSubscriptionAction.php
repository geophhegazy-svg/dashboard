<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Actions;

use App\Modules\Subscription\Domain\Contracts\HotspotSubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;

final readonly class DeleteHotspotSubscriptionAction
{
    public function __construct(
        private HotspotSubscriptionRepositoryInterface $repository,
    ) {}

    public function execute(
        HotspotSubscription $subscription
    ): bool {
        return $this->repository->delete(
            $subscription
        );
    }
}
