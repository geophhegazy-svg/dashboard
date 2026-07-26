<?php

declare(strict_types=1);

namespace App\Core\Kernel\Monitoring;

enum KernelBootStage: string
{
    case Discovery = 'module_discovery';

    case Validation = 'kernel_validation';

    case Compilation = 'manifest_compilation';

    case Registration = 'resource_registration';

    case Runtime = 'runtime_initialization';
}
