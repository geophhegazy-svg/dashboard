<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Workflows;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Invoice\Application\Actions\CreateInvoiceAction;

final readonly class CreateInvoiceWorkflow
{
    public function __construct(
        private CreateInvoiceAction $createInvoice,
    ) {}

    public function execute(
        array $data,
    ): Invoice {
        return $this->createInvoice->execute(
            $data,
        );
    }
}
