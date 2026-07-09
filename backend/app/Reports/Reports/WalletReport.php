<?php

declare(strict_types=1);

namespace App\Reports\Reports;

use App\Models\WalletTransaction;
use App\Reports\Abstracts\BaseReport;
use Illuminate\Database\Eloquent\Builder;

class WalletReport extends BaseReport
{
    public function name(): string
    {
        return 'wallet';
    }

    public function title(): string
    {
        return 'Wallet Report';
    }

    protected function query(): Builder
    {
        return WalletTransaction::query()
            ->with([
                'customer',
            ]);
    }

    protected function headers(): array
    {
        return [

            'Customer',

            'Transaction',

            'Amount',

            'Balance Before',

            'Balance After',

            'Reference',

            'Description',

            'Created At',

        ];
    }

    protected function map(iterable $records): array
    {
        $rows = [];

        foreach ($records as $transaction) {

            $rows[] = [

                'customer' => $transaction->customer?->name,

                'transaction' => $transaction->type,

                'amount' => (float) $transaction->amount,

                'balance_before' => (float) $transaction->balance_before,

                'balance_after' => (float) $transaction->balance_after,

                'reference' => $transaction->reference,

                'description' => $transaction->description,

                'created_at' => optional(
                    $transaction->created_at
                )->toDateTimeString(),

            ];
        }

        return $rows;
    }

    protected function summary(array $rows): array
    {
        return [

            'total_transactions' => count($rows),

            'total_deposits' => collect($rows)
                ->where('transaction', 'deposit')
                ->sum('amount'),

            'total_deductions' => collect($rows)
                ->where('transaction', 'deduct')
                ->sum('amount'),

            'net_amount' => collect($rows)
                ->reduce(function ($carry, $row) {

                    return $carry + (
                        $row['transaction'] === 'deposit'
                        ? $row['amount']
                        : -$row['amount']
                    );
                }, 0),

        ];
    }
}
