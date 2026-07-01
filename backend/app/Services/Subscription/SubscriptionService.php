<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Models\Subscription;
use App\Services\Network\MikrotikService;
use Illuminate\Support\Facades\DB;
use App\Events\SubscriptionActivated;
use App\Events\SubscriptionSuspended;
use App\Events\SubscriptionRenewed;
use App\Enums\SubscriptionStatus;


class SubscriptionService
{
    public function __construct(
        private readonly MikrotikService $mikrotikService
    ) {}

    /**
     * Activate subscription (Business Workflow)
     */
    public function activate(Subscription $subscription): bool
    {
        return DB::transaction(function () use ($subscription) {

            $this->updateStatus(
                $subscription,
                SubscriptionStatus::ACTIVE->value
            );
            $this->enablePppoeIfExists($subscription);
    
            SubscriptionActivated::dispatch($subscription);

            return true;
        });
    }

    /**
     * Suspend subscription
     */
    public function suspend(Subscription $subscription): bool
    {
        return DB::transaction(function () use ($subscription) {

            $this->updateStatus(
                $subscription,
                SubscriptionStatus::SUSPENDED->value
            );

            $this->disablePppoeIfExists($subscription);
            SubscriptionSuspended::dispatch($subscription);

            return true;
        });
    }

    /**
     * Renew subscription (basic version)
     */
    public function renew(Subscription $subscription, int $days = 30): bool
    {

        return DB::transaction(function () use ($subscription, $days) {

            $this->updateStatus(
                $subscription,
                SubscriptionStatus::ACTIVE->value
            );

            $subscription->update([
                'expires_at' => now()->addDays($days),
            ]);

            $this->enablePppoeIfExists($subscription);

            SubscriptionRenewed::dispatch($subscription);

            return true;
        });
    }

    /**
     * Expire subscription.
     */
    public function expire(Subscription $subscription): bool
    {
        return DB::transaction(function () use ($subscription) {

            $this->updateStatus(
                $subscription,
                SubscriptionStatus::EXPIRED->value
            );

            $this->disablePppoeIfExists(
                $subscription
            );

            // سيتم إضافة SubscriptionExpired Event لاحقًا.

            return true;
        });
    }

    /**
     * Restore an expired or suspended subscription.
     */
    public function restore(Subscription $subscription): bool
    {
        return DB::transaction(function () use ($subscription) {

            $this->updateStatus(
                $subscription,
                SubscriptionStatus::ACTIVE->value
            );

            $this->enablePppoeIfExists(
                $subscription
            );

            // سيتم إضافة SubscriptionRestored Event لاحقًا.

            return true;
        });
    }

    /**
     * Update subscription status.
     */
    private function updateStatus(
        Subscription $subscription,
        string $status
    ): void {
        $subscription->update([
            'status' => $status,
        ]);
    }

    /**
     * Enable PPPoE user if assigned.
     */
    private function enablePppoeIfExists(
        Subscription $subscription
    ): void {
        if (!$subscription->pppoe_username) {
            return;
        }

        $this->mikrotikService->enablePppoe(
            $subscription->pppoe_username
        );
    }

    /**
     * Disable PPPoE user if assigned.
     */
    private function disablePppoeIfExists(
        Subscription $subscription
    ): void {
        if (!$subscription->pppoe_username) {
            return;
        }

        $this->mikrotikService->disablePppoe(
            $subscription->pppoe_username
        );
    }
}
