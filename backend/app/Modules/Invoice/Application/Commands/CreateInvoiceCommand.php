<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Commands;

use App\Core\CommandBus\Contracts\CommandInterface;

final readonly class CreateInvoiceCommand implements CommandInterface
{
    public function __construct(
        public array $data,
    ) {}
}
