<?php

declare(strict_types=1);

namespace App\Reports\DTO;

final readonly class ExportResult
{
    public function __construct(
        public string $filename,
        public string $mimeType,
        public string $content,
        public int $size,
    ) {}
}
