<?php

declare(strict_types=1);

namespace App\Core\Kernel\Planning;

use App\Core\Kernel\Modules\Module;

final class BootPlanner
{
    /**
     * @param iterable<Module> $modules
     */
    public function plan(
        iterable $modules,
    ): BootPlan {

        return new BootPlan(
            iterator_to_array($modules, false),
        );
    }
}
