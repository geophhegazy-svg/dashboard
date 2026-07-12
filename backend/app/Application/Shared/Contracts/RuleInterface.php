<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

interface RuleInterface
{
    /**
     * Check whether the business rule passes.
     */
    public function passes(): bool;

    /**
     * Error message if rule fails.
     */
    public function message(): string;
}
