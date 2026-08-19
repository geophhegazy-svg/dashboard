<?php

declare(strict_types=1);

namespace App\Modules\Billing\Application\Services;

use App\Core\Workflow\WorkflowEngine;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Billing\Application\Workflows\GenerateInvoiceWorkflow;
use App\Modules\Billing\Domain\Contracts\InvoiceGeneratorInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

final class InvoiceGenerator implements InvoiceGeneratorInterface
{
    public function __construct(
        private readonly WorkflowEngine $engine,
        private readonly GenerateInvoiceWorkflow $workflow,
    ) {}

    public function generate(
        Subscription $subscription
    ): Invoice {

        $result = $this->engine->run(
            $this->workflow,
            $subscription,
        );

        /** @var Invoice $invoice */
        $invoice = $result->payload();

        return $invoice;
    }
}
