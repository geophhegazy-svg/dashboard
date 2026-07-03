<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Models\Subscription;
use App\Contracts\MikrotikServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Events\SubscriptionActivated;
use App\Events\SubscriptionSuspended;
use App\Events\SubscriptionRenewed;
use App\Enums\SubscriptionStatus;
use Illuminate\Validation\ValidationException;


class SubscriptionService
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotikService
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
                'end_date' => now()->addDays($days),
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

    /**
     * Return available PPPoE users that are not linked
     * to any subscription.
     */
    public function availablePppoeUsers(): array
    {
        $users = $this->mikrotikService->getPppoeUsers();

        $linkedUsers = Subscription::query()
            ->whereNotNull('pppoe_username')
            ->pluck('pppoe_username')
            ->toArray();

        return array_values(array_filter(
            $users,
            function ($user) use ($linkedUsers) {

                $username = $user['name'] ?? null;

                return $username &&
                    !in_array($username, $linkedUsers, true);
            }
        ));
    }

    /**
     * Link MikroTik PPPoE account to subscription.
     */
    public function linkPppoe(
        Subscription $subscription,
        string $username
    ): Subscription {

        $exists = $this->mikrotikService
            ->findPppoe($username);

        if (!$exists) {
            throw ValidationException::withMessages([
                'username' => [
                    'PPPoE user does not exist on MikroTik.'
                ],
            ]);
        }

        $alreadyLinked = Subscription::query()
            ->where('pppoe_username', $username)
            ->whereKeyNot($subscription->id)
            ->exists();

        if ($alreadyLinked) {
            throw ValidationException::withMessages([
                'username' => [
                    'PPPoE user is already linked to another subscription.'
                ],
            ]);
        }

        $subscription->update([
            'pppoe_username' => $username,
        ]);

        return $subscription->fresh();
    }
}
