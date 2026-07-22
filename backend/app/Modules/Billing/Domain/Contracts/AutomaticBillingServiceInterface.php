<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

interface AutomaticBillingServiceInterface
{
    public function run(Collection $subscriptions): void;

    public function processSubscription(
        Subscription $subscription
    ): void;
}
