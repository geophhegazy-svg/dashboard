<?php

declare(strict_types=1);

namespace App\Reports\DTO;

class ReportResult
{
    public function __construct(
        public readonly string $name,
        public readonly string $title,
        public readonly array $headers,
        public readonly array $rows,
        public readonly array $summary = [],
        public readonly array $meta = [],
    ) {}

    /**
     * Convert report to array.
     */
    public function toArray(): array
    {
        return [
            'name'    => $this->name,
            'title'   => $this->title,
            'headers' => $this->headers,
            'rows'    => $this->rows,
            'summary' => $this->summary,
            'meta'    => $this->meta,
        ];
    }

    /**
     * Number of rows.
     */
    public function count(): int
    {
        return count($this->rows);
    }

    /**
     * Empty report?
     */
    public function isEmpty(): bool
    {
        return empty($this->rows);
    }
}
