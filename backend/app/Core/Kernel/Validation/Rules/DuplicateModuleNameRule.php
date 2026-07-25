<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Rules;

use App\Core\Kernel\Contracts\KernelValidationRuleInterface;
use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\ValidationError;
use App\Core\Kernel\Validation\ValidationErrorCode;

final class DuplicateModuleNameRule implements KernelValidationRuleInterface
{
    /**
     * @return list<ValidationError>
     */
    public function validate(
        ModuleRegistry $registry,
    ): array {

        $errors = [];
        $names = [];

        foreach ($registry->all() as $module) {

            $name = $module->name();

            if (isset($names[$name])) {

                $errors[] = new ValidationError(
                    ValidationErrorCode::DuplicateModuleName,
                    sprintf(
                        'Duplicate module name [%s].',
                        $name,
                    ),
                );

                continue;
            }

            $names[$name] = true;
        }

        return $errors;
    }
}
