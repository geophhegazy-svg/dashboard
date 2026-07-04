<?php

declare(strict_types=1);

namespace App\Services\Billing;

use Carbon\Carbon;
use App\Enums\BillingStatus;

class BillingEngine
{
    public function status(
        Carbon $endDate,
        int $graceDays = 3
    ): BillingStatus {

        if ($endDate->isFuture()) {
            return BillingStatus::ACTIVE;
        }

        if ($endDate->isToday()) {
            return BillingStatus::DUE;
        }

        if (
            now()->lessThanOrEqualTo(
                $endDate->copy()->addDays($graceDays)
            )
        ) {
            return BillingStatus::GRACE;
        }

        return BillingStatus::EXPIRED;
    }
    
    public function nextDueDate(
        Carbon $date,
        string $cycle
    ): Carbon {

        return match ($cycle) {

            'daily' => $date->copy()->addDay(),

            'weekly' => $date->copy()->addWeek(),

            'monthly' => $date->copy()->addMonth(),

            'yearly' => $date->copy()->addYear(),

            default => throw new \InvalidArgumentException(
                'Unknown billing cycle.'
            ),
        };
    }
}
