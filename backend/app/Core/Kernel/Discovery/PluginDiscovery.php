<?php

declare(strict_types=1);

namespace App\Core\Kernel\Discovery;

use App\Core\Kernel\Discovery\Contracts\PluginSourceInterface;
use App\Core\Kernel\Plugins\Plugin;

final readonly class PluginDiscovery
{
    public function __construct(
        private PluginSourceInterface $source,
    ) {}


    /**
     * @return iterable<Plugin>
     */
    public function discover(): iterable
    {
        return $this->source->plugins();
    }
}
