<?php

declare(strict_types=1);

namespace App\Application\Shared\Contracts;

interface DTOInterface
{
    /**
     * Convert DTO to array.
     */
    public function toArray(): array;
}

