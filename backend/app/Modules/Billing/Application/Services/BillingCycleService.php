<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Services;

use App\Modules\Billing\Domain\Contracts\BillingCycleServiceInterface;
use Carbon\Carbon;

class BillingCycleService implements BillingCycleServiceInterface
{
    public function calculateNextBillingDate(
        Carbon $from,
        string $billingCycle,
        int $billingInterval
    ): Carbon {
        return match ($billingCycle) {
            'day' => $from->copy()->addDays($billingInterval),
            'week' => $from->copy()->addWeeks($billingInterval),
            'month' => $from->copy()->addMonths($billingInterval),
            'year' => $from->copy()->addYears($billingInterval),
            default => $from->copy()->addMonth(),
        };
    }

    public function calculateGraceDate(
        Carbon $billingDate,
        int $graceDays
    ): Carbon {
        return $billingDate
            ->copy()
            ->addDays($graceDays);
    }

    public function isDue(
        Carbon $nextBillingDate
    ): bool {
        return $nextBillingDate->lte(now());
    }

    public function isExpired(
        Carbon $graceDate
    ): bool {
        return $graceDate->lt(now());
    }
}
