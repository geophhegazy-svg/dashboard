<?php

declare(strict_types=1);

namespace App\Automation\DTOs;

final readonly class AutomationResult
{
    public function __construct(
        public int $processed = 0,
        public int $created = 0,
        public int $updated = 0,
        public int $skipped = 0,
        public int $failed = 0,
        public array $errors = [],
    ) {}

    public function isSuccessful(): bool
    {
        return $this->failed === 0;
    }

    public function hasErrors(): bool
    {
        return ! empty($this->errors);
    }

    public function toArray(): array
    {
        return [
            'processed' => $this->processed,
            'created'   => $this->created,
            'updated'   => $this->updated,
            'skipped'   => $this->skipped,
            'failed'    => $this->failed,
            'errors'    => $this->errors,
        ];
    }
}
