<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Commands\Handlers;

use App\Modules\Invoice\Application\Commands\DeleteInvoiceCommand;
use App\Modules\Invoice\Application\Services\InvoiceService;

final readonly class DeleteInvoiceCommandHandler
{
    public function __construct(
        private InvoiceService $service,
    ) {}

    public function handle(
        DeleteInvoiceCommand $command,
    ): bool {
        return $this->service->delete(
            $command->invoice,
        );
    }
}
