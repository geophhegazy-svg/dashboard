<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Services;

use App\Exceptions\Accounting\JournalPostingException;
use App\Modules\Accounting\Domain\Contracts\AccountingPeriodRepositoryInterface;
use Carbon\Carbon;

final readonly class AccountingPeriodService
{
    public function __construct(
        private AccountingPeriodRepositoryInterface $periods,
    ) {}

    public function assertOpenForDate(
        int $tenantId,
        Carbon $date,
    ): void {
        $period = $this->periods->findForDate(
            tenantId: $tenantId,
            date: $date,
        );

        if ($period === null) {
            throw new JournalPostingException(
                'Journal entry date does not belong to an accounting period.'
            );
        }

        if ($period->status->value !== 'open') {
            throw new JournalPostingException(
                'Journal entry cannot be posted in a closed accounting period.'
            );
        }
    }
}
