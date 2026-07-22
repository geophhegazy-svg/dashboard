<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Contracts;

use App\Models\Package;
use Carbon\Carbon;

interface BillingCycleServiceInterface
{
    public function calculateNextBillingDate(
        Carbon $from,
        Package $package
    ): Carbon;

    public function calculateGraceDate(
        Carbon $billingDate,
        Package $package
    ): Carbon;

    public function isDue(
        Carbon $nextBillingDate
    ): bool;

    public function isExpired(
        Carbon $graceDate
    ): bool;
}
