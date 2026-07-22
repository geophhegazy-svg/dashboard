<?php

declare(strict_types=1);

namespace App\Modules\Billing\Domain\Contracts;

use App\Models\Invoice;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

interface InvoiceGeneratorInterface
{
    public function generate(
        Subscription $subscription
    ): Invoice;
}
