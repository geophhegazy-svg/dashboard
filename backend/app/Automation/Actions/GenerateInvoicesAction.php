<?php

declare(strict_types=1);

namespace App\Automation\Actions;

use App\Models\Subscription;
use App\Services\Billing\InvoiceGeneratorService;

final readonly class GenerateInvoicesAction
{
    public function __construct(
        private InvoiceGeneratorService $invoiceGenerator,
    ) {}

    public function execute(Subscription $subscription): void
    {
        $this->invoiceGenerator->generate($subscription);
    }
}
