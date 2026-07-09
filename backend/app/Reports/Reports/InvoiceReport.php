<?php

declare(strict_types=1);

namespace App\Reports\Reports;

use App\Models\Invoice;
use App\Reports\Abstracts\BaseReport;
use Illuminate\Database\Eloquent\Builder;

class InvoiceReport extends BaseReport
{
    public function name(): string
    {
        return 'invoices';
    }

    public function title(): string
    {
        return 'Invoices Report';
    }

    protected function query(): Builder
    {
        return Invoice::query()
            ->with([
                'customer',
                'subscription',
            ]);
    }

    protected function headers(): array
    {
        return [
            'Invoice Number',
            'Customer',
            'Subscription',
            'Amount',
            'Status',
            'Due Date',
            'Paid At',
            'Created At',
        ];
    }

    protected function map(iterable $records): array
    {
        $rows = [];

        foreach ($records as $invoice) {

            $rows[] = [

                'invoice_number' => $invoice->invoice_number,

                'customer' => $invoice->customer?->name,

                'subscription' => $invoice->subscription?->id,

                'amount' => (float) $invoice->amount,

                'status' => $invoice->status,

                'due_date' => optional(
                    $invoice->due_date
                )->toDateString(),

                'paid_at' => optional(
                    $invoice->paid_at
                )->toDateTimeString(),

                'created_at' => optional(
                    $invoice->created_at
                )->toDateTimeString(),

            ];
        }

        return $rows;
    }

    protected function summary(array $rows): array
    {
        return [

            'total_invoices' => count($rows),

            'paid' => collect($rows)
                ->where('status', 'paid')
                ->count(),

            'pending' => collect($rows)
                ->where('status', 'pending')
                ->count(),

            'cancelled' => collect($rows)
                ->where('status', 'cancelled')
                ->count(),

            'total_amount' => collect($rows)
                ->sum('amount'),

            'paid_amount' => collect($rows)
                ->where('status', 'paid')
                ->sum('amount'),

            'outstanding_amount' => collect($rows)
                ->where('status', 'pending')
                ->sum('amount'),

        ];
    }
}
