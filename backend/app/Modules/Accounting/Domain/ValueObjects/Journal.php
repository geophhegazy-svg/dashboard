<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Domain\ValueObjects;

final readonly class Journal
{
    /**
     * @param JournalLine[] $lines
     */
    public function __construct(
        public string $description,
        public ?string $reference,
        public array $lines,
    ) {}
}
