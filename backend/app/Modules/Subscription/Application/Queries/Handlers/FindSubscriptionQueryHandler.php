<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Queries\Handlers;

use App\Core\QueryBus\Contracts\QueryHandlerInterface;
use App\Core\QueryBus\Contracts\QueryInterface;
use App\Modules\Subscription\Application\Queries\FindSubscriptionQuery;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use LogicException;

final readonly class FindSubscriptionQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptions,
    ) {}

    public function handle(
        QueryInterface $query,
    ): ?Subscription {
        if (! $query instanceof FindSubscriptionQuery) {
            throw new LogicException('FindSubscriptionQueryHandler received an unsupported query.');
        }

        return $this->subscriptions->find($query->subscriptionId);
    }
}
