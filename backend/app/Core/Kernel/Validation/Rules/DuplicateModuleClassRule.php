<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Rules;

use App\Core\Kernel\Contracts\KernelValidationRuleInterface;
use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\ValidationError;
use App\Core\Kernel\Validation\ValidationErrorCode;

final class DuplicateModuleClassRule
implements KernelValidationRuleInterface
{
    /**
     * @return list<ValidationError>
     */
    public function validate(
        ModuleRegistry $registry,
    ): array {

        $errors = [];

        $classes = [];

        foreach ($registry->all() as $module) {

            $class = $module::class;

            if (isset($classes[$class])) {

                $errors[] = new ValidationError(
                    ValidationErrorCode::DuplicateModuleClass,
                    sprintf(
                        'Duplicate module class [%s].',
                        $class,
                    ),
                );

                continue;
            }

            $classes[$class] = true;
        }

        return $errors;
    }
}
