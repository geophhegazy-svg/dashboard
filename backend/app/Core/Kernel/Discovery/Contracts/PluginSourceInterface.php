<?php

declare(strict_types=1);

namespace App\Core\Kernel\Discovery\Contracts;

use App\Core\Kernel\Plugins\Plugin;

interface PluginSourceInterface
{
    /**
     * @return iterable<Plugin>
     */
    public function plugins(): iterable;
}
