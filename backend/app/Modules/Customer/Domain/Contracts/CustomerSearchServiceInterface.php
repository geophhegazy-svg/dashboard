<?php

declare(strict_types=1);

namespace App\Modules\Customer\Domain\Contracts;

interface CustomerSearchServiceInterface
{
    public function search(array $filters): iterable;
}
