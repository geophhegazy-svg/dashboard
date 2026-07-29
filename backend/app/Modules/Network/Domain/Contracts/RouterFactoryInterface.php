<?php

declare(strict_types=1);

namespace App\Modules\Network\Domain\Contracts;

interface RouterFactoryInterface
{
    /**
     * Create router provider.
     */
    public function make(string $driver): RouterProviderInterface;
}
