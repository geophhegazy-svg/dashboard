<?php

declare(strict_types=1);

namespace App\Enums;

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

    /*
    |--------------------------------------------------------------------------
    | State Helpers
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }

    public function isClosed(): bool
    {
        return match ($this) {
            self::CANCELLED,
            self::TERMINATED => true,

            default => false,
        };
    }

    public function canActivate(): bool
    {
        return match ($this) {
            self::PENDING,
            self::SUSPENDED => true,

            default => false,
        };
    }

    public function canSuspend(): bool
    {
        return $this === self::ACTIVE;
    }

    public function canRenew(): bool
    {
        return match ($this) {
            self::ACTIVE,
            self::GRACE,
            self::EXPIRED => true,

            default => false,
        };
    }

    public function canExpire(): bool
    {
        return match ($this) {
            self::ACTIVE,
            self::GRACE => true,

            default => false,
        };
    }

    public function canRestore(): bool
    {
        return match ($this) {
            self::SUSPENDED,
            self::EXPIRED => true,

            default => false,
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending Activation',
            self::ACTIVE => 'Active',
            self::GRACE => 'Grace Period',
            self::SUSPENDED => 'Suspended',
            self::EXPIRED => 'Expired',
            self::CANCELLED => 'Cancelled',
            self::TERMINATED => 'Terminated',
        };
    }
}
