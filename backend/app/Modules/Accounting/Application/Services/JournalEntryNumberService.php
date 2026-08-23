<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Services;

use App\Modules\Accounting\Domain\Contracts\JournalEntryRepositoryInterface;

final readonly class JournalEntryNumberService
{
    public function __construct(
        private JournalEntryRepositoryInterface $journalEntries,
    ) {}

    public function generate(): string
    {
        $year = now()->year;

        $last = $this->journalEntries->findLatestForYear(
            $year
        );

        $next = 1;

        if ($last !== null) {
            $parts = explode('-', $last->entry_number);

            $next = ((int) end($parts)) + 1;
        }

        return sprintf(
            'JV-%d-%06d',
            $year,
            $next
        );
    }
}
