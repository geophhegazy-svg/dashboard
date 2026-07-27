<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Knowledge;

interface KnowledgeExtractorInterface
{
    public function extract(): array;
}
