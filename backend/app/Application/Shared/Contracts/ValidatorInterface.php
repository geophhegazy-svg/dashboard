<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

interface ValidatorInterface
{
    /**
     * Validate given data.
     */
    public function validate(mixed ...$arguments): void;
}
