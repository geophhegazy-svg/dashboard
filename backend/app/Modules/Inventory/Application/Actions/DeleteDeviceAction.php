<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Actions;

use App\Modules\Inventory\Domain\Contracts\DeviceRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;

final readonly class DeleteDeviceAction
{
    public function __construct(
        private DeviceRepositoryInterface $repository,
    ) {}

    public function execute(Device $device): bool
    {
        return $this->repository->delete($device);
    }
}
