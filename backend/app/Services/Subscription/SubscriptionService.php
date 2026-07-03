<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Actions\Subscription\ActivateSubscriptionAction;
use App\Actions\Subscription\RenewSubscriptionAction;
use App\Contracts\MikrotikServiceInterface;
use App\Models\Subscription;
use Illuminate\Validation\ValidationException;

class SubscriptionService
{
    public function __construct(
        private readonly ActivateSubscriptionAction $activateAction,
        private readonly SuspendSubscriptionAction $suspendAction,
        private readonly ExpireSubscriptionAction $expireAction,
        private readonly RenewSubscriptionAction $renewAction,
    ) {}

    public function activate(Subscription $subscription): bool
    {
        return $this->activateAction->execute($subscription);
    }

    public function suspend(Subscription $subscription): bool
    {
        return $this->suspendAction->execute($subscription);
    }

    public function expire(Subscription $subscription): bool
    {
        return $this->expireAction->execute($subscription);
    }

    public function renew(Subscription $subscription, int $days = 30): bool
    {
        return $this->renewAction->execute($subscription, $days);
    }

    public function restore(Subscription $subscription): bool
    {
        $subscription->update([
            'status' => SubscriptionStatus::ACTIVE->value,
        ]);

        if ($subscription->pppoe_username) {
            $this->mikrotikService->enablePppoe($subscription->pppoe_username);
        }

        return true;
    }
}