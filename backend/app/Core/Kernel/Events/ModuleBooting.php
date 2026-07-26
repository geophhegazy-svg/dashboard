<?php

declare(strict_types=1);

namespace App\Core\Kernel\Events;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\Kernel\Contracts\ModuleContract;

final readonly class ModuleBooting implements EventContract
{
    public function __construct(
        public ModuleContract $module,
    ) {}
}
