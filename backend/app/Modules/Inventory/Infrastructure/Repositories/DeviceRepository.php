<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Repositories;

use App\Modules\Inventory\Domain\Contracts\DeviceRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class DeviceRepository implements DeviceRepositoryInterface
{
    public function paginate(): LengthAwarePaginator
    {
        return Device::latest()->paginate();
    }

    public function find(int $id): ?Device
    {
        return Device::find($id);
    }

    public function findOrFail(int $id): Device
    {
        return Device::findOrFail($id);
    }

    public function create(array $data): Device
    {
        return Device::create($data);
    }

    public function update(Device $device, array $data): Device
    {
        $device->update($data);

        return $device->fresh();
    }

    public function delete(Device $device): bool
    {
        return (bool) $device->delete();
    }
}
