<?php

declare(strict_types=1);

namespace App\Services\Payment;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function create(array $data): Payment
    {
        return DB::transaction(function () use ($data) {

            $invoice = Invoice::findOrFail(
                $data['invoice_id']
            );

            if ($invoice->status === 'paid') {
                abort(422, 'Invoice already paid');
            }

            $totalPaidBefore = $invoice
                ->payments()
                ->sum('amount');

            $data['tenant_id'] = $invoice->tenant_id;

            if (! isset($data['payment_date'])) {
                $data['payment_date'] = now();
            }

            $payment = Payment::create($data);

            $totalPaidAfter =
                $totalPaidBefore + $payment->amount;

            if ($totalPaidAfter >= $invoice->amount) {

                $invoice->update([
                    'status'  => 'paid',
                    'paid_at' => now(),
                ]);

                $extraCredit = max(
                    0,
                    $totalPaidAfter - $invoice->amount
                );

                if ($extraCredit > 0) {

                    if ($invoice->subscription) {

                        $invoice->subscription->increment(
                            'wallet_balance',
                            $extraCredit
                        );
                    }

                    if ($invoice->hotspotSubscription) {

                        $invoice->hotspotSubscription->increment(
                            'wallet_balance',
                            $extraCredit
                        );
                    }
                }
            }

            return $payment;
        });
    }

    public static function createFromInvoice(
        Invoice $invoice,
        float $amount,
        string $method = 'wallet',
        string $reference = 'AUTO-WALLET',
        ?string $notes = null
    ): Payment {
        return Payment::create([
            'tenant_id'        => $invoice->tenant_id,
            'invoice_id'       => $invoice->id,
            'amount'           => $amount,
            'payment_date'     => now(),
            'payment_method'   => $method,
            'reference_number' => $reference,
            'notes'            => $notes,
        ]);
    }
}
