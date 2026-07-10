<?php

declare(strict_types=1);

namespace App\Data\Finance;

final readonly class JournalEntryData
{
    /**
     * @param JournalEntryLineData[] $lines
     */
    public function __construct(
        public string $entryDate,
        public ?string $reference,
        public ?string $description,
        public int $createdBy,
        public array $lines,
    ) {}
}
