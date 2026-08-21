<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Repositories;

use App\Modules\Inventory\Domain\Contracts\InventoryRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class InventoryRepository implements InventoryRepositoryInterface
{
    public function paginate(): LengthAwarePaginator
    {
        return Inventory::latest()->paginate();
    }

    public function find(int $id): ?Inventory
    {
        return Inventory::find($id);
    }

    public function findByDevice(
        int $tenantId,
        string $deviceType,
        string $brand,
        ?string $model,
    ): ?Inventory {
        return Inventory::query()
            ->where('tenant_id', $tenantId)
            ->where('device_type', $deviceType)
            ->where('brand', $brand)
            ->where('model', $model)
            ->first();
    }

    public function decrementQuantity(Inventory $inventory): void
    {
        $inventory->decrement('quantity');
    }

    public function incrementQuantity(Inventory $inventory): void
    {
        $inventory->increment('quantity');
    }

    public function create(array $data): Inventory
    {
        return Inventory::create($data);
    }

    public function update(
        Inventory $inventory,
        array $data
    ): Inventory {
        $inventory->update($data);

        return $inventory->fresh();
    }

    public function delete(Inventory $inventory): bool
    {
        return (bool) $inventory->delete();
    }
}
