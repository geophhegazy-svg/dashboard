<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Actions;

use App\Modules\Inventory\Domain\Contracts\DeviceRepositoryInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;

final readonly class CreateDeviceAction
{
    public function __construct(
        private DeviceRepositoryInterface $repository,
    ) {}

    public function execute(array $data): Device
    {
        return $this->repository->create($data);
    }
}
