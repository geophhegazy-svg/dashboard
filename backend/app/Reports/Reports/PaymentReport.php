<?php

declare(strict_types=1);

namespace App\Reports\Reports;

use App\Models\Payment;
use App\Reports\Abstracts\BaseReport;
use Illuminate\Database\Eloquent\Builder;

class PaymentReport extends BaseReport
{
    public function name(): string
    {
        return 'payments';
    }

    public function title(): string
    {
        return 'Payments Report';
    }

    protected function query(): Builder
    {
        return Payment::query()
            ->with([
                'invoice',
                'invoice.customer',
            ]);
    }

    protected function headers(): array
    {
        return [

            'Payment ID',

            'Invoice',

            'Customer',

            'Amount',

            'Method',

            'Reference',

            'Payment Date',

            'Created At',

        ];
    }

    protected function map(iterable $records): array
    {
        $rows = [];

        foreach ($records as $payment) {

            $rows[] = [

                'payment_id' => $payment->id,

                'invoice' => $payment->invoice?->invoice_number,

                'customer' => $payment->invoice?->customer?->name,

                'amount' => (float) $payment->amount,

                'method' => $payment->payment_method,

                'reference' => $payment->reference_number,

                'payment_date' => optional(
                    $payment->payment_date
                )->toDateTimeString(),

                'created_at' => optional(
                    $payment->created_at
                )->toDateTimeString(),

            ];
        }

        return $rows;
    }

    protected function summary(array $rows): array
    {
        return [

            'total_payments' => count($rows),

            'total_collected' => collect($rows)
                ->sum('amount'),

            'wallet_payments' => collect($rows)
                ->where('method', 'wallet')
                ->count(),

            'cash_payments' => collect($rows)
                ->where('method', 'cash')
                ->count(),

            'bank_payments' => collect($rows)
                ->where('method', 'bank')
                ->count(),

            'other_payments' => collect($rows)
                ->reject(function ($row) {
                    return in_array(
                        $row['method'],
                        [
                            'wallet',
                            'cash',
                            'bank',
                        ],
                        true
                    );
                })
                ->count(),

        ];
    }
}
