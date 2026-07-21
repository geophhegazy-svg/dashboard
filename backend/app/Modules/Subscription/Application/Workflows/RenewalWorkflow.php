<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows;

use Throwable;
use App\Core\DTO\RenewalResult;
use App\Modules\Subscription\Application\Actions\RenewSubscriptionAction;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;

final readonly class RenewalWorkflow
{
    public function __construct(
        private SubscriptionRepositoryInterface $subscriptions,
        private RenewSubscriptionAction $renewAction,
    ) {}

    public function run(
        int $days = 30,
    ): RenewalResult {

        $processed = 0;
        $renewed = 0;
        $failed = 0;
        $errors = [];

        $eligibleSubscriptions =
            $this->subscriptions
            ->findEligibleForAutoRenew();

        foreach ($eligibleSubscriptions as $subscription) {

            $processed++;

            try {

                $this->renewAction->execute(
                    $subscription,
                    $days
                );

                $renewed++;
            } catch (Throwable $exception) {

                $failed++;

                $errors[] = sprintf(
                    'Subscription #%d: %s',
                    $subscription->id,
                    $exception->getMessage()
                );
            }
        }

        return new RenewalResult(
            processed: $processed,
            renewed: $renewed,
            failed: $failed,
            errors: $errors,
        );
    }
}
