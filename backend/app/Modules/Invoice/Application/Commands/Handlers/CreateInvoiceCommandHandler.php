<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Commands\Handlers;

use App\Modules\Invoice\Application\Commands\CreateInvoiceCommand;
use App\Modules\Invoice\Application\Services\InvoiceService;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;

final readonly class CreateInvoiceCommandHandler
{
    public function __construct(
        private InvoiceService $service,
    ) {}

    public function handle(
        CreateInvoiceCommand $command,
    ): Invoice {
        return $this->service->create(
            $command->data,
        );
    }
}
