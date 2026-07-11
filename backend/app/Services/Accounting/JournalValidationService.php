<?php

declare(strict_types=1);

namespace App\Services\Accounting;

use App\Exceptions\Accounting\JournalValidationException;
use App\Models\JournalEntry;

class JournalValidationService
{
    public function validate(JournalEntry $entry): void
    {
        $entry->loadMissing('lines');

        $this->validateHasLines($entry);

        $this->validateAccounts($entry);

        $this->validateAmounts($entry);

        $this->validateBalanced($entry);
    }

    private function validateHasLines(JournalEntry $entry): void
    {
        if ($entry->lines->count() < 2) {
            throw new JournalValidationException(
                'Journal entry must contain at least two lines.'
            );
        }
    }

    private function validateAccounts(JournalEntry $entry): void
    {
        foreach ($entry->lines as $line) {
            if (empty($line->account_id)) {
                throw new JournalValidationException(
                    'Journal entry line has invalid account.'
                );
            }
        }
    }

    private function validateAmounts(JournalEntry $entry): void
    {
        foreach ($entry->lines as $line) {

            $debit = (float) $line->debit;
            $credit = (float) $line->credit;

            if ($debit < 0 || $credit < 0) {
                throw new JournalValidationException(
                    'Negative amounts are not allowed.'
                );
            }

            if ($debit == 0.0 && $credit == 0.0) {
                throw new JournalValidationException(
                    'Journal entry line must contain either debit or credit.'
                );
            }

            if ($debit > 0.0 && $credit > 0.0) {
                throw new JournalValidationException(
                    'Journal entry line cannot contain both debit and credit.'
                );
            }
        }
    }

    private function validateBalanced(JournalEntry $entry): void
    {
        $debit = (float) $entry->lines->sum('debit');

        $credit = (float) $entry->lines->sum('credit');

        if (abs($debit - $credit) > 0.00001) {
            throw new JournalValidationException(
                'Journal entry is not balanced.'
            );
        }
    }
}
