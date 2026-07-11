<?php

declare(strict_types=1);

namespace App\Services\Billing;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Services\Invoice\InvoiceNumberService;

class InvoiceGenerator
{
    public function __construct(
        private readonly InvoiceNumberService $invoiceNumberService
    ) {}

    public function generate(Subscription $subscription): Invoice
    {
        return Invoice::create([
            'tenant_id'         => $subscription->tenant_id,
            'customer_id'       => $subscription->customer_id,
            'subscription_id'   => $subscription->id,
            'invoice_number' => InvoiceNumberService::generate(),
            'amount'            => $subscription->package->price,
            'due_date'          => now()->toDateString(),
            'status'            => 'pending',
        ]);
    }
}
