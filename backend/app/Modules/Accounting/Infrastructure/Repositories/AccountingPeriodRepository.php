<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Infrastructure\Repositories;

use App\Modules\Accounting\Domain\Contracts\AccountingPeriodRepositoryInterface;
use App\Modules\Accounting\Infrastructure\Persistence\Models\AccountingPeriod;
use Carbon\Carbon;

final class AccountingPeriodRepository implements AccountingPeriodRepositoryInterface
{
    public function findForDate(
        int $tenantId,
        Carbon $date,
    ): ?AccountingPeriod {
        return AccountingPeriod::query()
            ->where('tenant_id', $tenantId)
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->first();
    }
}
