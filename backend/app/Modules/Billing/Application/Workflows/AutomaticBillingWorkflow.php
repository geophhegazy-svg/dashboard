<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Workflows;

use Throwable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Enums\BillingStatus;
use App\Modules\Billing\Domain\Services\BillingEngine;
use App\Modules\Notification\Application\Contracts\NotificationServiceInterface;
use App\Modules\Subscription\Application\Contracts\SubscriptionRenewalServiceInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class AutomaticBillingWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly BillingEngine $billingEngine,
        private readonly SubscriptionRenewalServiceInterface $renewalService,
        private readonly NotificationServiceInterface $notificationService,
    ) {}

    protected function perform(
        WorkflowContextInterface $context,
    ): mixed {

        /** @var \Illuminate\Support\Collection $subscriptions */
        $subscriptions = $context->dto()[0] ?? collect();

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

            $this->renewalService->renew(
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
