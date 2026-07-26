<?php

declare(strict_types=1);

namespace App\Core\Contracts;

interface ContainerInterface
{
    public function make(
        string $abstract
    ): object;
}
