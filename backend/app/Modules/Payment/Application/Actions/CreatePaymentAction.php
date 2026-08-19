<?php

declare(strict_types=1);

namespace App\Modules\Payment\Application\Actions;

use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;
use App\Modules\Payment\Domain\Contracts\PaymentRepositoryInterface;
use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use App\Modules\Wallet\Application\Contracts\WalletServiceInterface;
use Illuminate\Support\Facades\DB;

final readonly class CreatePaymentAction
{
    public function __construct(
        private PaymentRepositoryInterface $repository,
        private InvoiceServiceInterface $invoiceService,
        private WalletServiceInterface $walletService,
    ) {}

    public function execute(
        array $data,
    ): Payment {
        return DB::transaction(function () use ($data): Payment {

            $invoice = $this->invoiceService->findForPayment(
                $data['invoice_id'],
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
                (float) $totalPaidBefore
                + (float) $payment->amount;

            $this->invoiceService->settle(
                $invoice,
                $totalPaidAfter,
            );

            if ($totalPaidAfter >= (float) $invoice->amount) {

                $extraCredit = max(
                    0,
                    $totalPaidAfter - (float) $invoice->amount,
                );

                if (
                    $extraCredit > 0
                    && $invoice->subscription
                ) {
                    $this->walletService->credit(
                        tenantId: $invoice->tenant_id,
                        customerId: $invoice->customer_id,
                        amount: $extraCredit,
                        description: 'Invoice overpayment credit',
                        reference: $invoice->invoice_number,
                    );
                }
            }

            return $payment->refresh();
        });
    }
}
