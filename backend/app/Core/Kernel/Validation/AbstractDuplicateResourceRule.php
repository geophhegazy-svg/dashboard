<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation;

use App\Core\Kernel\Contracts\KernelValidationRuleInterface;
use App\Core\Kernel\ModuleRegistry;

abstract class AbstractDuplicateResourceRule implements KernelValidationRuleInterface
{
    /**
     * اسم المورد (services, actions, ...)
     */
    abstract protected function resourceName(): string;

    /**
     * نوع الخطأ.
     */
    abstract protected function errorCode(): ValidationErrorCode;

    /**
     * استخراج جميع الموارد الخاصة بالـ Module.
     *
     * @return iterable<string>
     */
    abstract protected function resources(object $module): iterable;

    /**
     * @return list<ValidationError>
     */
    public function validate(
        ModuleRegistry $registry,
    ): array {

        $seen = [];

        $errors = [];

        foreach ($registry->all() as $module) {

            foreach ($this->resources($module) as $resource) {

                if (! isset($seen[$resource])) {

                    $seen[$resource] = $module->name();

                    continue;
                }

                $errors[] = new ValidationError(
                    $this->errorCode(),
                    sprintf(
                        'Duplicate %s [%s] found in modules [%s] and [%s].',
                        $this->resourceName(),
                        $resource,
                        $seen[$resource],
                        $module->name(),
                    ),
                );
            }
        }

        return $errors;
    }
}
