<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Queries;

use App\Core\QueryBus\Contracts\QueryInterface;

final readonly class FindSubscriptionQuery implements QueryInterface
{
    public function __construct(
        public int $subscriptionId,
    ) {}
}
