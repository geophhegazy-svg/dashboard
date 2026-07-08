<?php

declare(strict_types=1);

namespace App\Actions\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Events\SubscriptionActivated;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ActivateSubscriptionAction
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotikService,
    ) {}

    public function execute(Subscription $subscription): bool
    {
        if (! $subscription->canActivate()) {
            throw new RuntimeException(
                sprintf(
                    'Subscription #%d cannot be activated from status [%s].',
                    $subscription->id,
                    $subscription->status->value
                )
            );
        }

        return DB::transaction(function () use ($subscription) {

            /*
            |--------------------------------------------------------------------------
            | Change State
            |--------------------------------------------------------------------------
            */

            $subscription->activate();
            $subscription->save();

            /*
            |--------------------------------------------------------------------------
            | Enable PPPoE
            |--------------------------------------------------------------------------
            */

            if (! empty($subscription->pppoe_username)) {
                $this->mikrotikService->enableUser(
                    $subscription->pppoe_username
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Dispatch Event
            |--------------------------------------------------------------------------
            */

            SubscriptionActivated::dispatch($subscription);

            return true;
        });
    }
}
