<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\ValidationError;

interface KernelValidationRuleInterface
{
    /**
     * @return list<ValidationError>
     */
    public function validate(
        ModuleRegistry $registry,
    ): array;
}
