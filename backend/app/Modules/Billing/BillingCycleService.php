<?php

declare(strict_types=1);

namespace App\Modules\Billing;

use App\Models\Package;
use Carbon\Carbon;

class BillingCycleService
{
    public function calculateNextBillingDate(
        Carbon $from,
        Package $package
    ): Carbon {

        return match ($package->billing_cycle) {

            'day' => $from->copy()->addDays(
                $package->billing_interval
            ),

            'week' => $from->copy()->addWeeks(
                $package->billing_interval
            ),

            'month' => $from->copy()->addMonths(
                $package->billing_interval
            ),

            'year' => $from->copy()->addYears(
                $package->billing_interval
            ),

            default => $from->copy()->addMonth(),
        };
    }

    public function calculateGraceDate(
        Carbon $billingDate,
        Package $package
    ): Carbon {

        return $billingDate->copy()
            ->addDays($package->grace_days);
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
