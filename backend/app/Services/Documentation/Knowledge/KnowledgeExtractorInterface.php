<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

interface KnowledgeExtractorInterface
{
    public function extract(): array;
}
