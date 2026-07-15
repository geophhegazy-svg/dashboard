<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Contracts;

use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;

interface SubscriptionStateInterface
{
    /**
     * State identifier.
     */
    public function status(): SubscriptionStatus;

    /**
     * Can activate?
     */
    public function canActivate(): bool;

    /**
     * Can suspend?
     */
    public function canSuspend(): bool;

    /**
     * Can expire?
     */
    public function canExpire(): bool;

    /**
     * Can restore?
     */
    public function canRestore(): bool;

    /**
     * Can renew?
     */
    public function canRenew(): bool;
}
