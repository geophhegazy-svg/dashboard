<?php

declare(strict_types=1);

namespace App\Core\Kernel\Discovery\Contracts;

use App\Core\Kernel\Modules\Module;

interface ModuleSourceInterface
{
    /**
     * @return iterable<Module>
     */
    public function modules(): iterable;
}
