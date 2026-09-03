<?php

declare(strict_types=1);

namespace App\Modules\Network\Domain\Contracts;

use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use Illuminate\Database\Eloquent\Collection;

interface NetworkDeviceRepositoryInterface
{
    public function find(int $id): ?NetworkDevice;

    public function findOrFail(int $id): NetworkDevice;

    public function active(): Collection;
}
