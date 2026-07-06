<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Enums\SubscriptionStatus;
use App\Events\SubscriptionActivated;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

class ActivateSubscriptionAction
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotikService,
    ) {}

    public function execute(
        Subscription $subscription
    ): bool {

        return DB::transaction(function () use ($subscription) {

            $subscription->update([
                'status' => SubscriptionStatus::ACTIVE->value,
            ]);

            if (! empty($subscription->pppoe_username)) {
                $this->mikrotikService->enablePppoe(
                    $subscription->pppoe_username
                );
            }

            SubscriptionActivated::dispatch($subscription);

            return true;
        });
    }
}
