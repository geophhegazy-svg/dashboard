<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use Illuminate\Support\Facades\Log;

final readonly class AutoExpireSubscriptionsWorkflow
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptions,
        private ExpireWorkflow $expireWorkflow,
    ) {}

    public function execute(): int
    {
        $subscriptions = $this->subscriptions->expiredCandidates();

        $count = 0;

        foreach ($subscriptions as $subscription) {

            $this->expireWorkflow->execute(
                $subscription,
            );

            $count++;
        }

        Log::info(
            'Subscriptions auto expired.',
            [
                'count' => $count,
            ],
        );

        return $count;
    }
}
