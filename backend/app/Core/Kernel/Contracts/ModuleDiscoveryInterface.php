<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

interface ModuleDiscoveryInterface
{
    /**
     * @return iterable<\App\Core\Kernel\Modules\Module>
     */
    public function discover(): iterable;
}
