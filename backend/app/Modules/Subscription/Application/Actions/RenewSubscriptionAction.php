<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Actions;

use App\Core\Contracts\ActionInterface;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class RenewSubscriptionAction implements ActionInterface
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptions,
    ) {}

    public function execute(
        mixed ...$arguments
    ): Subscription {
        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        $days = (int) ($arguments[1] ?? 30);

        $subscription->renew($days);

        $this->subscriptions->save($subscription);

        return $subscription->fresh();
    }
}
