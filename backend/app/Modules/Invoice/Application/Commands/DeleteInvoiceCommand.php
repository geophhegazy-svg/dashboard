<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Commands;

use App\Core\CommandBus\Contracts\CommandInterface;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;

final readonly class DeleteInvoiceCommand implements CommandInterface
{
    public function __construct(
        public Invoice $invoice,
    ) {}
}
