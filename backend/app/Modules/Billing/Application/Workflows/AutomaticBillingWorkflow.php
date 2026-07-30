<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Workflows;

use Throwable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Core\Workflow\AbstractWorkflow;
use App\Enums\BillingStatus;
use App\Modules\Billing\Domain\Services\BillingEngine;
use App\Modules\Notification\Application\Services\NotificationService;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRenewalServiceInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class AutomaticBillingWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly BillingEngine $billingEngine,
        private readonly SubscriptionRenewalServiceInterface $renewalService,
        private readonly NotificationService $notificationService,
    ) {}

    protected function perform(
        mixed ...$arguments
    ): mixed {

        /** @var \Illuminate\Support\Collection $subscriptions */
        $subscriptions = $arguments[0];

        foreach ($subscriptions as $subscription) {

            try {

                $this->process(
                    $subscription,
                );
            } catch (Throwable $exception) {

                Log::error(
                    'Automatic billing failed.',
                    [
                        'subscription_id' => $subscription->id,
                        'customer_id'     => $subscription->customer_id,
                        'message'         => $exception->getMessage(),
                    ]
                );
            }
        }

        return null;
    }

    private function process(
        Subscription $subscription,
    ): void {

        if (! $subscription->canRenew()) {
            return;
        }

        $status = $this->billingEngine->status(
            $subscription->end_date,
        );

        if (
            $status === BillingStatus::ACTIVE ||
            $status === BillingStatus::GRACE
        ) {
            return;
        }

        try {

            $this->renewalService->renewPppoe(
                $subscription,
            );
        } catch (Throwable $exception) {

            Log::error(
                'Subscription automatic renewal failed.',
                [
                    'subscription_id' => $subscription->id,
                    'message' => $exception->getMessage(),
                ]
            );

            $this->notificationService->billingFailed(
                $subscription,
            );

            throw $exception;
        }
    }
}
