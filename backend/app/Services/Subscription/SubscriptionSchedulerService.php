<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SubscriptionSchedulerService
{
    public function __construct(
        private readonly SubscriptionRenewalService $renewalService,
        private readonly SubscriptionService $subscriptionService,
    ) {}

    /**
     * Auto renew all eligible subscriptions.
     */
    public function autoRenew(): int
    {
        $count = 0;

        $subscriptions = Subscription::query()
            ->where('status', SubscriptionStatus::ACTIVE)
            ->whereDate('end_date', '<=', Carbon::today())
            ->get();

        foreach ($subscriptions as $subscription) {
            try {
                $this->renewalService->renewPppoe($subscription);

                $count++;
            } catch (\Throwable $e) {
                Log::error(
                    'Automatic renewal failed.',
                    [
                        'subscription_id' => $subscription->id,
                        'message' => $e->getMessage(),
                    ]
                );
            }
        }

        return $count;
    }

    /**
     * Move subscriptions to grace period.
     */
    public function enterGracePeriod(): int
    {
        return 0;
    }

    /**
     * Expire subscriptions after grace period.
     */
    public function expireSubscriptions(): int
    {
        return 0;
    }

    /**
     * Synchronize database with MikroTik.
     */
    public function synchronize(): int
    {
        return 0;
    }
}
