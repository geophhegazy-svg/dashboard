<?php

declare(strict_types=1);

namespace App\Modules\Billing;

use App\Enums\BillingStatus;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Notification\Application\Services\NotificationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Throwable;
use App\Modules\Billing\Domain\Services\BillingEngine;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRenewalServiceInterface;


class AutomaticBillingService
{
    public function __construct(
        private readonly BillingEngine $billingEngine,
        private readonly SubscriptionRenewalServiceInterface $renewalService,
        private readonly NotificationService $notificationService,
    ) {}

    /**
     * Process all subscriptions.
     */
    public function run(Collection $subscriptions): void
    {
        foreach ($subscriptions as $subscription) {
            try {
                $this->processSubscription($subscription);
            } catch (Throwable $e) {
                Log::error(
                    'Automatic billing failed.',
                    [
                        'subscription_id' => $subscription->id,
                        'customer_id'     => $subscription->customer_id,
                        'message'         => $e->getMessage(),
                    ]
                );
            }
        }
    }

    /**
     * Process a single subscription.
     */
    public function processSubscription(
        Subscription $subscription
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Ignore subscriptions that cannot be renewed
        |--------------------------------------------------------------------------
        */

        if (! $subscription->canRenew()) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Billing status
        |--------------------------------------------------------------------------
        */

        $status = $this->billingEngine->status(
            $subscription->end_date
        );

        /*
        |--------------------------------------------------------------------------
        | Active or Grace Period
        |--------------------------------------------------------------------------
        */

        if (
            $status === BillingStatus::ACTIVE ||
            $status === BillingStatus::GRACE
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Renew Subscription
        |--------------------------------------------------------------------------
        */

        try {

            $this->renewalService->renewPppoe($subscription);
        } catch (Throwable $e) {

            Log::error(
                'Subscription automatic renewal failed.',
                [
                    'subscription_id' => $subscription->id,
                    'message' => $e->getMessage(),
                ]
            );

            $this->notificationService->billingFailed(
                $subscription
            );

            throw $e;
        }
    }
}
