<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Contracts;

use Carbon\Carbon;

interface BillingCycleServiceInterface
{
    public function calculateNextBillingDate(
        Carbon $from,
        string $billingCycle,
        int $billingInterval
    ): Carbon;

    public function calculateGraceDate(
        Carbon $billingDate,
        int $graceDays
    ): Carbon;

    public function isDue(
        Carbon $nextBillingDate
    ): bool;

    public function isExpired(
        Carbon $graceDate
    ): bool;
}
