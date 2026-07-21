<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Services;

use App\Models\JournalEntry;

class JournalEntryNumberService
{
    public function generate(): string
    {
        $year = now()->year;

        $last = JournalEntry::query()
            ->whereYear('entry_date', $year)
            ->orderByDesc('id')
            ->first();

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
