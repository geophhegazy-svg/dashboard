<?php

declare(strict_types=1);

namespace App\Core\Kernel\Discovery;

use App\Core\Kernel\Contracts\ModuleContract;

class ModuleDiscovery
{
    /**
     * @return ModuleContract[]
     */
    public function discover(): array
    {
        $modules = require base_path(
            'app/Modules/modules.php'
        );


        return array_map(
            fn(string $module) => new $module(),
            $modules
        );
    }
}
