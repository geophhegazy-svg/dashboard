<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Application\Commands;

use App\Core\CommandBus\Contracts\CommandInterface;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Device;

final readonly class UpdateDeviceCommand implements CommandInterface
{
    public function __construct(
        public Device $device,
        public array $data,
    ) {}
}
