<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Services;

use App\Modules\Subscription\Application\Workflows\RenewWorkflow;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRenewalServiceInterface;

final readonly class SubscriptionRenewalService implements SubscriptionRenewalServiceInterface
{
    public function __construct(
        private RenewWorkflow $workflow,
    ) {}

    public function renewPppoe(
        Subscription $subscription,
    ): bool {

        $this->workflow->execute(
            $subscription
        );

        return true;
    }
}
