<?php

declare(strict_types=1);

namespace App\Automation\Actions;

use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final readonly class GenerateInvoicesAction
{
    public function __construct(
        private InvoiceServiceInterface $invoiceService,
    ) {}

    public function execute(Subscription $subscription): void
    {
        $this->invoiceService->create([
            'tenant_id'       => $subscription->tenant_id,
            'customer_id'     => $subscription->customer_id,
            'subscription_id' => $subscription->id,
            'amount'          => $subscription->package->price,
            'due_date'        => now()->toDateString(),
            'status'          => 'pending',
        ]);
    }
}
