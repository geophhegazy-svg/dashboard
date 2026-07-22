<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface RuleInterface
{
    public function validate(
        mixed ...$arguments
    ): void;
}
