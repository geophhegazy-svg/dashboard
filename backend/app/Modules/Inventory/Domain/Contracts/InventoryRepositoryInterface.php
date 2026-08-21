<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Domain\Contracts;

use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface InventoryRepositoryInterface
{
    public function paginate(): LengthAwarePaginator;

    public function find(int $id): ?Inventory;

    public function findByDevice(
        int $tenantId,
        string $deviceType,
        string $brand,
        ?string $model,
    ): ?Inventory;

    public function decrementQuantity(Inventory $inventory): void;

    public function incrementQuantity(Inventory $inventory): void;

    public function create(array $data): Inventory;

    public function update(
        Inventory $inventory,
        array $data
    ): Inventory;

    public function delete(Inventory $inventory): bool;
}
