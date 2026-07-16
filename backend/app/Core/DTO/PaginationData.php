<?php

declare(strict_types=1);

namespace App\Core\DTO;

final readonly class PaginationData
{
    public function __construct(
        public int $currentPage,
        public int $perPage,
        public int $total,
        public int $lastPage,
        public ?int $from = null,
        public ?int $to = null,
        public bool $hasMorePages = false,
    ) {}

    public static function make(
        int $currentPage,
        int $perPage,
        int $total,
        int $lastPage,
        ?int $from = null,
        ?int $to = null,
        bool $hasMorePages = false,
    ): self {
        return new self(
            currentPage: $currentPage,
            perPage: $perPage,
            total: $total,
            lastPage: $lastPage,
            from: $from,
            to: $to,
            hasMorePages: $hasMorePages,
        );
    }

    public function toArray(): array
    {
        return [
            'current_page' => $this->currentPage,
            'per_page' => $this->perPage,
            'total' => $this->total,
            'last_page' => $this->lastPage,
            'from' => $this->from,
            'to' => $this->to,
            'has_more_pages' => $this->hasMorePages,
        ];
    }
}
