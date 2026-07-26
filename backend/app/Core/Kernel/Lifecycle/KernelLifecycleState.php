<?php

declare(strict_types=1);

namespace App\Core\Kernel\Lifecycle;

enum KernelLifecycleState: string
{
    case Created = 'created';

    case Starting = 'starting';

    case Booting = 'booting';

    case Ready = 'ready';

    case Failed = 'failed';

    case Stopping = 'stopping';

    case Stopped = 'stopped';
}
