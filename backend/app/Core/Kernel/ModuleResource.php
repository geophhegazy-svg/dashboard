<?php

declare(strict_types=1);

namespace App\Core\Kernel;

enum ModuleResource: string
{
    case ACTIONS = 'actions';

    case LISTENERS = 'listeners';

    case QUERIES = 'queries';
}
