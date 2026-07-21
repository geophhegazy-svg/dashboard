<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Contracts;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

interface SubscriptionRenewalServiceInterface
{
    public function renewPppoe(
        Subscription $subscription,
    ): bool;
}
