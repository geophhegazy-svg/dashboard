<?php

declare(strict_types=1);

namespace App\Core\Results\Contracts;

interface ResultInterface
{
    public function successful(): bool;

    public function failed(): bool;

    public function message(): ?string;

    public function data(): mixed;

    public function errors(): array;

    public function code(): ?string;

    public function meta(): array;

    public function toArray(): array;
}
