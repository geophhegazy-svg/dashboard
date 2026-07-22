<?php

declare(strict_types=1);

namespace App\Modules\Customer\Domain\Contracts;

interface CustomerNumberGeneratorInterface
{
    public function generate(): string;
}
