<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Extractors;

use App\Core\Kernel\Contracts\ModuleContract;

interface ResourceExtractorInterface
{
    /**
     * @return iterable<string>
     */
    public function extract(
        ModuleContract $module,
    ): iterable;
}
