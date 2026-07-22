<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Services;

use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;
use App\Enums\BillingStatus;
use App\Modules\Billing\Domain\Services\BillingEngine;
use App\Modules\Notification\Application\Services\NotificationService;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRenewalServiceInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Billing\Domain\Contracts\AutomaticBillingServiceInterface;

class AutomaticBillingService implements AutomaticBillingServiceInterface
{
    public function __construct(
        private readonly BillingEngine $billingEngine,
        private readonly SubscriptionRenewalServiceInterface $renewalService,
        private readonly NotificationService $notificationService,
    ) {}

    public function run(
        Collection $subscriptions
    ): void {

        foreach ($subscriptions as $subscription) {

            try {

                $this->processSubscription(
                    $subscription
                );
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

    public function processSubscription(
        Subscription $subscription
    ): void {

        if (! $subscription->canRenew()) {
            return;
        }

        $status = $this->billingEngine->status(
            $subscription->end_date
        );

        if (
            $status === BillingStatus::ACTIVE ||
            $status === BillingStatus::GRACE
        ) {
            return;
        }

        try {

            $this->renewalService->renewPppoe(
                $subscription
            );
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
