<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Domain\Contracts;

use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DeviceRepositoryInterface
{
    public function paginate(): LengthAwarePaginator;

    public function find(int $id): ?Device;

    public function findOrFail(int $id): Device;

    public function create(array $data): Device;

    public function update(Device $device, array $data): Device;

    public function delete(Device $device): bool;
}
