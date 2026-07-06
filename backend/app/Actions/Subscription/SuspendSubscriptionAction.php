<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Events\SubscriptionSuspended;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class SuspendSubscriptionAction
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotikService,
    ) {}

    public function execute(Subscription $subscription): bool
    {
        if (! $subscription->canSuspend()) {
            throw new RuntimeException(
                sprintf(
                    'Subscription #%d cannot be suspended from status [%s].',
                    $subscription->id,
                    $subscription->status->value
                )
            );
        }

        return DB::transaction(function () use ($subscription) {

            /*
            |--------------------------------------------------------------------------
            | Change Subscription State
            |--------------------------------------------------------------------------
            */
            $subscription->suspend();
            $subscription->save();

            /*
            |--------------------------------------------------------------------------
            | Disable PPPoE on MikroTik
            |--------------------------------------------------------------------------
            */
            if (! empty($subscription->pppoe_username)) {
                $this->mikrotikService->disablePppoe(
                    $subscription->pppoe_username
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Dispatch Domain Event
            |--------------------------------------------------------------------------
            */
            SubscriptionSuspended::dispatch($subscription);

            return true;
        });
    }
}
