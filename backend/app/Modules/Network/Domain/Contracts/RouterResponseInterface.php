<?php

declare(strict_types=1);

namespace App\Modules\Network\Domain\Contracts;

interface RouterResponseInterface
{
    /**
     * Was request successful?
     */
    public function successful(): bool;

    /**
     * Response payload.
     *
     * @return array<int,array<string,mixed>>
     */
    public function data(): array;

    /**
     * Error message.
     */
    public function message(): ?string;
}
