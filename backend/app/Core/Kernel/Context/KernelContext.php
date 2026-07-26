<?php

declare(strict_types=1);

namespace App\Core\Kernel\Context;

use App\Core\Kernel\Runtime\KernelRuntimeContext;

final readonly class KernelContext
{
    public function __construct(
        private KernelRuntimeContext $runtime,
    ) {}


    public function runtime(): KernelRuntimeContext
    {
        return $this->runtime;
    }


    public function manifest()
    {
        return $this->runtime->manifest();
    }


    public function bootedAt()
    {
        return $this->runtime->bootedAt();
    }
}
