<?php

declare(strict_types=1);

namespace App\Modules\Payment\Application\Services;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use App\Modules\Payment\Application\Workflows\CreatePaymentWorkflow;

class PaymentService
{
    public function __construct(
        private readonly CreatePaymentWorkflow $createPayment,
    ) {}

    public function create(
        array $data,
    ): Payment {

        return $this->createPayment->execute(
            $data,
        );
    }

    public function createFromInvoice(
        Invoice $invoice,
        float $amount,
        string $method = 'wallet',
        string $reference = 'AUTO-WALLET',
        ?string $notes = null,
    ): Payment {

        return $this->create([
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
