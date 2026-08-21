<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands;

use App\Core\CommandBus\Contracts\CommandInterface;

final readonly class CreateInventoryCommand implements CommandInterface
{
    public function __construct(
        public array $data,
    ) {}
}
