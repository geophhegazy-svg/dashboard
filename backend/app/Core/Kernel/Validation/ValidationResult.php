<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation;

final readonly class ValidationResult
{
    /**
     * @param list<ValidationError> $errors
     * @param list<string> $warnings
     */
    public function __construct(
        private array $errors = [],
        private array $warnings = [],
    ) {}

    public function isValid(): bool
    {
        return $this->errors === [];
    }

    public function hasErrors(): bool
    {
        return $this->errors !== [];
    }

    public function hasWarnings(): bool
    {
        return $this->warnings !== [];
    }

    /**
     * @return list<ValidationError>
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @return list<string>
     */
    public function warnings(): array
    {
        return $this->warnings;
    }

    public function errorCount(): int
    {
        return count($this->errors);
    }

    public function warningCount(): int
    {
        return count($this->warnings);
    }

    public function exceptionMessage(): string
    {
        $messages = [];

        foreach ($this->errors as $error) {

            $messages[] = $error->format();
        }

        return implode(
            PHP_EOL,
            $messages,
        );
    }
}
