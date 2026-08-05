<?php

declare(strict_types=1);

namespace App\Modules\Payment\Application\Actions;

use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Payment\Domain\Contracts\PaymentRepositoryInterface;
use Illuminate\Support\Facades\DB;

final readonly class CreatePaymentAction
{
    public function __construct(
        private PaymentRepositoryInterface $repository,
    ) {}

    public function execute(
        array $data,
    ): Payment {

        return DB::transaction(function () use ($data): Payment {

            $invoice = Invoice::findOrFail(
                $data['invoice_id']
            );

            if ($invoice->status === 'paid') {
                abort(422, 'Invoice already paid');
            }

            $totalPaidBefore = $invoice
                ->payments()
                ->sum('amount');

            $payment = $this->repository->create([
                ...$data,
                'tenant_id' => $invoice->tenant_id,
                'payment_date' => $data['payment_date'] ?? now(),
            ]);

            $totalPaidAfter =
                $totalPaidBefore + $payment->amount;

            if ($totalPaidAfter >= $invoice->amount) {

                $invoice->update([
                    'status' => 'paid',
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

            return $payment->refresh();
        });
    }
}
