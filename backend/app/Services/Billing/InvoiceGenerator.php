<?php

declare(strict_types=1);

namespace App\Services\Billing;

use App\Events\InvoiceCreated;
use App\Models\Invoice;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Services\Invoice\InvoiceNumberService;

class InvoiceGenerator
{
    public function __construct(
        private readonly InvoiceNumberService $invoiceNumberService
    ) {}

    public function generate(
        Subscription $subscription
    ): Invoice {

        $invoice = Invoice::create([

            'tenant_id'       => $subscription->tenant_id,

            'customer_id'     => $subscription->customer_id,

            'subscription_id' => $subscription->id,

            'invoice_number'  => $this->invoiceNumberService->generate(),

            'amount'          => $subscription->package->price,

            'due_date'        => now()->toDateString(),

            'status'          => 'pending',
        ]);


        InvoiceCreated::dispatch(
            $invoice
        );


        return $invoice;
    }
}
