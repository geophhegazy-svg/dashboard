<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Domain\Events;

use App\Core\EventBus\Contracts\EventContract;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class InvoiceCreated implements EventContract
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public readonly Invoice $invoice,
    ) {}
}
