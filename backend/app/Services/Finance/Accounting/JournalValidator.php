<?php

declare(strict_types=1);

namespace App\Services\Finance\Accounting;

use App\Exceptions\Finance\InvalidAccountException;
use App\Exceptions\Finance\InvalidJournalLineException;
use App\Exceptions\Finance\UnbalancedJournalException;
use App\Models\Account;

class JournalValidator
{
    public function validate(array $lines): void
    {
        if (count($lines) < 2) {
            throw new InvalidJournalLineException(
                'A journal entry must contain at least two lines.'
            );
        }

        $totalDebit = 0;
        $totalCredit = 0;

        foreach ($lines as $line) {
            $account = Account::find($line['account_id']);

            if (! $account) {
                throw new InvalidAccountException(
                    "Account {$line['account_id']} does not exist."
                );
            }

            if (! $account->is_active) {
                throw new InvalidAccountException(
                    "Account {$account->code} is inactive."
                );
            }

            $debit = (float) ($line['debit'] ?? 0);
            $credit = (float) ($line['credit'] ?? 0);

            if ($debit < 0 || $credit < 0) {
                throw new InvalidJournalLineException(
                    'Debit and credit cannot be negative.'
                );
            }

            if ($debit > 0 && $credit > 0) {
                throw new InvalidJournalLineException(
                    'A journal line cannot contain both debit and credit.'
                );
            }

            if ($debit == 0 && $credit == 0) {
                throw new InvalidJournalLineException(
                    'A journal line must contain either debit or credit.'
                );
            }

            $totalDebit += $debit;
            $totalCredit += $credit;
        }

        if (round($totalDebit, 2) !== round($totalCredit, 2)) {
            throw new UnbalancedJournalException(
                'Journal entry is not balanced.'
            );
        }
    }
}
