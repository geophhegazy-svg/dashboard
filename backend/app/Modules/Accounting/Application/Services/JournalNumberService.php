<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Services;

use App\Modules\Accounting\Domain\Contracts\JournalEntryRepositoryInterface;
use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;

final readonly class JournalNumberService
{
    public function __construct(
        private JournalEntryRepositoryInterface $repository,
    ) {}

    public function generate(
        int $tenantId,
        int $year,
    ): string {
        $latest = $this->repository->findLatestForYear(
            tenantId: $tenantId,
            year: $year,
        );

        $sequence = 1;

        if ($latest !== null) {
            $prefix = "JV-{$year}-";

            if (str_starts_with($latest->entry_number, $prefix)) {
                $sequence =
                    ((int) substr(
                        $latest->entry_number,
                        strlen($prefix),
                    )) + 1;
            }
        }

        return sprintf(
            'JV-%d-%06d',
            $year,
            $sequence,
        );
    }
}
