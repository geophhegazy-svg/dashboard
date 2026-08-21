<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Actions;

use App\Modules\Inventory\Domain\Contracts\InventoryRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;

final readonly class UpdateInventoryAction
{
    public function __construct(
        private InventoryRepositoryInterface $repository,
    ) {}

    public function execute(
        Inventory $inventory,
        array $data,
    ): Inventory {
        return $this->repository->update(
            $inventory,
            $data,
        );
    }
}
