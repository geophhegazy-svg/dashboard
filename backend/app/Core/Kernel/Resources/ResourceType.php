<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

enum ResourceType: string
{
    case Services = 'services';

    case Singletons = 'singletons';

    case Actions = 'actions';

    case Commands = 'commands';

    case CommandHandlers = 'command_handlers';

    case Queries = 'queries';

    case Listeners = 'listeners';

    case Policies = 'policies';

    case Migrations = 'migrations';

    case Config = 'config';

    case Routes = 'routes';

    case Schedule = 'schedule';
}
