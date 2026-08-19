<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Workflows;

use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class GenerateInvoiceWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly InvoiceServiceInterface $invoiceService,
    ) {}

    protected function perform(
        WorkflowContextInterface $context,
    ): Invoice {

        /** @var Subscription $subscription */
        $subscription = $context->dto()[0] ?? null;

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
