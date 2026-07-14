<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Enums;

enum SubscriptionStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case GRACE = 'grace';
    case SUSPENDED = 'suspended';
    case EXPIRED = 'expired';
    case CANCELLED = 'cancelled';
    case TERMINATED = 'terminated';

    /**
     * -----------------------------------------------------------------
     * Allowed State Transitions
     * -----------------------------------------------------------------
     */
    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }

    /**
     * -----------------------------------------------------------------
     * Transition Map
     * -----------------------------------------------------------------
     */
    public function allowedTransitions(): array
    {
        return match ($this) {

            self::DRAFT => [
                self::PENDING,
                self::CANCELLED,
            ],

            self::PENDING => [
                self::ACTIVE,
                self::CANCELLED,
            ],

            self::ACTIVE => [
                self::SUSPENDED,
                self::GRACE,
                self::EXPIRED,
                self::CANCELLED,
            ],

            self::GRACE => [
                self::ACTIVE,
                self::EXPIRED,
                self::CANCELLED,
            ],

            self::SUSPENDED => [
                self::ACTIVE,
                self::CANCELLED,
            ],

            self::EXPIRED => [
                self::ACTIVE,
                self::TERMINATED,
            ],

            self::CANCELLED => [
                self::TERMINATED,
            ],

            self::TERMINATED => [],
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Compatibility Helpers
    |--------------------------------------------------------------------------
    */

    public function canActivate(): bool
    {
        return $this->canTransitionTo(self::ACTIVE);
    }

    public function canSuspend(): bool
    {
        return $this->canTransitionTo(self::SUSPENDED);
    }

    public function canRenew(): bool
    {
        return $this->canTransitionTo(self::ACTIVE);
    }

    public function canExpire(): bool
    {
        return $this->canTransitionTo(self::EXPIRED);
    }

    public function canRestore(): bool
    {
        return $this->canTransitionTo(self::ACTIVE);
    }

    public function canCancel(): bool
    {
        return $this->canTransitionTo(self::CANCELLED);
    }

    public function canTerminate(): bool
    {
        return $this->canTransitionTo(self::TERMINATED);
    }

    /*
    |--------------------------------------------------------------------------
    | State Helpers
    |--------------------------------------------------------------------------
    */

    public function isDraft(): bool
    {
        return $this === self::DRAFT;
    }

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }

    public function isGrace(): bool
    {
        return $this === self::GRACE;
    }

    public function isSuspended(): bool
    {
        return $this === self::SUSPENDED;
    }

    public function isExpired(): bool
    {
        return $this === self::EXPIRED;
    }

    public function isCancelled(): bool
    {
        return $this === self::CANCELLED;
    }

    public function isTerminated(): bool
    {
        return $this === self::TERMINATED;
    }

    public function isClosed(): bool
    {
        return in_array($this, [
            self::CANCELLED,
            self::TERMINATED,
        ], true);
    }

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending',
            self::ACTIVE => 'Active',
            self::GRACE => 'Grace Period',
            self::SUSPENDED => 'Suspended',
            self::EXPIRED => 'Expired',
            self::CANCELLED => 'Cancelled',
            self::TERMINATED => 'Terminated',
        };
    }
}
