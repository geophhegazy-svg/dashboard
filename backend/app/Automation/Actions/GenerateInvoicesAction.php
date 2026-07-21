<?php

declare(strict_types=1);

namespace App\Automation\Actions;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Billing\InvoiceGenerator;

final readonly class GenerateInvoicesAction
{
    public function __construct(
        private InvoiceGenerator $invoiceGenerator,
    ) {}

    public function execute(Subscription $subscription): void
    {
        $this->invoiceGenerator->generate($subscription);
    }
}
