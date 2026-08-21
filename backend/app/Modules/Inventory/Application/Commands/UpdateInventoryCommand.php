<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands;

use App\Core\CommandBus\Contracts\CommandInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;

final readonly class UpdateInventoryCommand implements CommandInterface
{
    public function __construct(
        public Inventory $inventory,
        public array $data,
    ) {}
}
