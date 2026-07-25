<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Rules;

use App\Core\Kernel\Contracts\KernelValidationRuleInterface;
use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\ValidationError;
use App\Core\Kernel\Validation\ValidationErrorCode;

final class MissingDependencyRule
implements KernelValidationRuleInterface
{
    public function validate(
        ModuleRegistry $registry,
    ): array {

        $errors = [];

        foreach ($registry->all() as $module) {

            foreach ($module->dependencies() as $dependency) {

                if ($registry->has($dependency)) {
                    continue;
                }

                $errors[] = new ValidationError(
                    ValidationErrorCode::MissingDependency,
                    sprintf(
                        'Module [%s] depends on missing module [%s].',
                        $module->name(),
                        $dependency,
                    ),
                );
            }
        }

        return $errors;
    }
}
