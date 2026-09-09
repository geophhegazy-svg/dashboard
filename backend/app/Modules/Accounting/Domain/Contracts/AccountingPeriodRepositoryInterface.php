<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Domain\Contracts;

use App\Modules\Accounting\Infrastructure\Persistence\Models\AccountingPeriod;
use Carbon\Carbon;

interface AccountingPeriodRepositoryInterface
{
    public function findForDate(
        int $tenantId,
        Carbon $date,
    ): ?AccountingPeriod;
}
