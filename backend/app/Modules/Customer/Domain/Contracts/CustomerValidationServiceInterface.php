<?php

declare(strict_types=1);

namespace App\Modules\Customer\Domain\Contracts;

interface CustomerValidationServiceInterface
{
    public function validate(array $data): void;
}
