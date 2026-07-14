<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Models\Subscription;
use RuntimeException;

class SubscriptionRulesService
{
    /**
     * Ensure subscription can be activated.
     */
    public function ensureCanActivate(
        Subscription $subscription
    ): void {

        if (! $subscription->canActivate()) {

            throw new RuntimeException(
                sprintf(
                    'Subscription #%d cannot be activated.',
                    $subscription->id
                )
            );
        }

        $this->ensurePackageIsActive($subscription);

        $this->ensureCustomerIsActive($subscription);
    }

    /**
     * Ensure subscription can be renewed.
     */
    public function ensureCanRenew(
        Subscription $subscription
    ): void {

        if (! $subscription->canRenew()) {

            throw new RuntimeException(
                sprintf(
                    'Subscription #%d cannot be renewed.',
                    $subscription->id
                )
            );
        }

        $this->ensurePackageIsActive($subscription);

        $this->ensureCustomerIsActive($subscription);
    }

    /**
     * Ensure subscription can be suspended.
     */
    public function ensureCanSuspend(
        Subscription $subscription
    ): void {

        if (! $subscription->canSuspend()) {

            throw new RuntimeException(
                sprintf(
                    'Subscription #%d cannot be suspended.',
                    $subscription->id
                )
            );
        }
    }

    /**
     * Customer must be active.
     */
    public function ensureCustomerIsActive(
        Subscription $subscription
    ): void {

        if (! $subscription->customer) {

            throw new RuntimeException(
                'Customer not found.'
            );
        }

        if (
            property_exists($subscription->customer, 'status')
            && $subscription->customer->status !== 'active'
        ) {

            throw new RuntimeException(
                'Customer account is not active.'
            );
        }
    }

    /**
     * Package must be active.
     */
    public function ensurePackageIsActive(
        Subscription $subscription
    ): void {

        if (! $subscription->package) {

            throw new RuntimeException(
                'Package not found.'
            );
        }

        if (
            property_exists($subscription->package, 'is_active')
            && ! $subscription->package->is_active
        ) {

            throw new RuntimeException(
                'Package is disabled.'
            );
        }
    }

    /**
     * Subscription expired?
     */
    public function isExpired(
        Subscription $subscription
    ): bool {

        if ($subscription->end_date === null) {
            return false;
        }

        return $subscription->end_date->isPast();
    }

    /**
     * Subscription in grace period?
     */
    public function isInGracePeriod(
        Subscription $subscription,
        int $days = 7
    ): bool {

        if ($subscription->end_date === null) {
            return false;
        }

        return now()->diffInDays(
            $subscription->end_date,
            false
        ) >= -$days;
    }
}
