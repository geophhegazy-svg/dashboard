<?php

declare(strict_types=1);

namespace App\Core\Exceptions\Contracts;

use Throwable;

interface ExceptionInterface extends Throwable
{
    public function codeName(): ?string;

    public function context(): array;

    public function toArray(): array;
}
