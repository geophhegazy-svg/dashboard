<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\QueryHandlers;

use App\Core\QueryBus\Contracts\QueryHandlerInterface;
use App\Modules\Subscription\Application\Queries\FindSubscriptionQuery;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class FindSubscriptionHandler implements QueryHandlerInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $repository,
    ) {}

    public function handle(
        FindSubscriptionQuery $query,
    ): ?Subscription {
        return $this->repository->find(
            $query->subscriptionId
        );
    }
}
