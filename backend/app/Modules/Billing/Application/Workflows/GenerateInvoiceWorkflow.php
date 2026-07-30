<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Workflows;

use App\Core\Workflow\AbstractWorkflow;
use App\Models\Invoice;
use App\Modules\Invoice\Application\Services\InvoiceService;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class GenerateInvoiceWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly InvoiceService $invoiceService,
    ) {}

    protected function perform(
        mixed ...$arguments
    ): Invoice {

        /** @var Subscription $subscription */
        $subscription = $arguments[0];

        return $this->invoiceService->create([
            'tenant_id'       => $subscription->tenant_id,
            'customer_id'     => $subscription->customer_id,
            'subscription_id' => $subscription->id,
            'amount'          => $subscription->package->price,
            'due_date'        => now()->toDateString(),
            'status'          => 'pending',
        ]);
    }
}
