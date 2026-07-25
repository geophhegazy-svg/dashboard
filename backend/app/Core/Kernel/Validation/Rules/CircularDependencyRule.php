<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Rules;

use App\Core\Kernel\Contracts\KernelValidationRuleInterface;
use App\Core\Kernel\ModuleRegistry;
use App\Core\Kernel\Validation\ValidationError;
use App\Core\Kernel\Validation\ValidationErrorCode;

final class CircularDependencyRule implements KernelValidationRuleInterface
{
    /**
     * @return list<ValidationError>
     */
    public function validate(
        ModuleRegistry $registry,
    ): array {

        $errors = [];

        $visited = [];

        $stack = [];

        foreach ($registry->all() as $module) {

            $this->visit(
                $module::class,
                $registry,
                $visited,
                $stack,
                $errors,
            );
        }

        return $errors;
    }

    /**
     * @param array<class-string,bool> $visited
     * @param array<class-string,bool> $stack
     * @param list<ValidationError> $errors
     */
    private function visit(
        string $moduleClass,
        ModuleRegistry $registry,
        array &$visited,
        array &$stack,
        array &$errors,
    ): void {

        if (isset($stack[$moduleClass])) {

            $errors[] = new ValidationError(
                ValidationErrorCode::CircularDependency,
                sprintf(
                    'Circular dependency detected for [%s].',
                    $moduleClass,
                ),
            );

            return;
        }

        if (isset($visited[$moduleClass])) {
            return;
        }

        $visited[$moduleClass] = true;

        $stack[$moduleClass] = true;

        $module = $registry->get(
            $moduleClass,
        );

        if ($module !== null) {

            foreach (
                $module->dependencies()
                as $dependency
            ) {

                $this->visit(
                    $dependency,
                    $registry,
                    $visited,
                    $stack,
                    $errors,
                );
            }
        }

        unset(
            $stack[$moduleClass],
        );
    }
}
