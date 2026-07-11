<?php

declare(strict_types=1);

namespace App\Contracts\Network;

interface RouterFactoryInterface
{
    /**
     * Create router provider.
     */
    public function make(string $driver): RouterProviderInterface;
}
