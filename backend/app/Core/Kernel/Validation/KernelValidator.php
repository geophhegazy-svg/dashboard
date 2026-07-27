<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation;

use App\Core\Kernel\Contracts\KernelValidationRuleInterface;
use App\Core\Kernel\Contracts\KernelValidatorInterface;
use App\Core\Kernel\ModuleRegistry;

final readonly class KernelValidator
implements KernelValidatorInterface
{
    /**
     * @param iterable<KernelValidationRuleInterface> $rules
     */
    public function __construct(
        private KernelValidationRuleRegistry $registry,
    ) {}

    public function validate(
        ModuleRegistry $registry,
    ): ValidationResult {

        $errors = [];

        foreach ($this->registry->rules() as $rule) {

            array_push(
                $errors,
                ...$rule->validate(
                    $registry,
                ),
            );
        }

        return new ValidationResult(
            errors: $errors,
        );
    }
}
