<?php

declare(strict_types=1);

namespace App\Core\Kernel\Lifecycle\Events;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;

final readonly class KernelStarting
implements EventContract
{
    public function __construct(
        public KernelLifecycleState $state,
    ) {}
}
