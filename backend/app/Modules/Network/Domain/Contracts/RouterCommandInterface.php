<?php

declare(strict_types=1);

namespace App\Modules\Network\Domain\Contracts;

interface RouterCommandInterface
{
    /**
     * Command path.
     *
     * Example:
     * /ppp/secret/print
     */
    public function path(): string;

    /**
     * Command parameters.
     *
     * @return array<string,mixed>
     */
    public function parameters(): array;
}
