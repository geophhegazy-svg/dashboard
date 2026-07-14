<?php

declare(strict_types=1);

namespace App\Core\DTO;

abstract readonly class DataTransferObject
{
    /**
     * Convert DTO to array.
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
