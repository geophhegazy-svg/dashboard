<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Enums\SubscriptionStatus;
use App\Models\Subscription;
use App\Events\SubscriptionSuspended;
use Illuminate\Support\Facades\DB;

class SuspendSubscriptionAction
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotikService
    ) {}

    public function execute(Subscription $subscription): bool
    {
        return DB::transaction(function () use ($subscription) {

            $subscription->update([
                'status' => SubscriptionStatus::SUSPENDED->value,
            ]);

            if ($subscription->pppoe_username) {
                $this->mikrotikService->disablePppoe(
                    $subscription->pppoe_username
                );
            }

            SubscriptionSuspended::dispatch($subscription);

            return true;
        });
    }
}
