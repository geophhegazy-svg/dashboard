<?php

declare(strict_types=1);

namespace App\Modules\Network\Infrastructure\Repositories;

use App\Modules\Network\Domain\Contracts\NetworkDeviceRepositoryInterface;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use Illuminate\Database\Eloquent\Collection;

final class NetworkDeviceRepository implements NetworkDeviceRepositoryInterface
{
    public function find(int $id): ?NetworkDevice
    {
        return NetworkDevice::find($id);
    }

    public function findOrFail(int $id): NetworkDevice
    {
        return NetworkDevice::findOrFail($id);
    }

    public function active(): Collection
    {
        return NetworkDevice::active()->get();
    }
}
