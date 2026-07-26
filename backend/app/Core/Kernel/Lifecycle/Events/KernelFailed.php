<?php

declare(strict_types=1);

namespace App\Core\Kernel\Lifecycle\Events;

use App\Core\EventBus\Contracts\EventContract;
use Throwable;

final readonly class KernelFailed
implements EventContract
{
    public function __construct(
        public Throwable $exception,
    ) {}
}
