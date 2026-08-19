<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Contracts;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

interface SubscriptionRenewalServiceInterface
{
    public function renew(
        Subscription $subscription,
    ): bool;
}
