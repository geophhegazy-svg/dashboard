<?php

declare(strict_types=1);

namespace App\Core\Kernel\Events;

use App\Core\EventBus\Contracts\EventContract;

final readonly class KernelBooting implements EventContract {}
