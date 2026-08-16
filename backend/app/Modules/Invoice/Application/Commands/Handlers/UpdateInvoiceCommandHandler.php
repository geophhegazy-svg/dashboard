<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Commands\Handlers;

use App\Modules\Invoice\Application\Commands\UpdateInvoiceCommand;
use App\Modules\Invoice\Application\Services\InvoiceService;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;

final readonly class UpdateInvoiceCommandHandler
{
    public function __construct(
        private InvoiceService $service,
    ) {}

    public function handle(
        UpdateInvoiceCommand $command,
    ): Invoice {
        return $this->service->update(
            $command->invoice,
            $command->data,
        );
    }
}
