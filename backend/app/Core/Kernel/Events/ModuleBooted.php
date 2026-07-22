<?php

declare(strict_types=1);

namespace App\Core\Kernel\Events;

use App\Core\Kernel\Modules\Module;

final readonly class ModuleBooted
{
    public function __construct(
        public Module $module,
    ) {}
}
