<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Actions;

use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class DeleteSubscriptionAction
{
    public function __construct(
        private SubscriptionRepositoryInterface $repository,
    ) {}

    public function execute(
        Subscription $subscription,
    ): bool {
        return $this->repository->delete(
            $subscription,
        );
    }
}