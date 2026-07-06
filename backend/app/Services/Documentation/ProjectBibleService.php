<?php

declare(strict_types=1);

namespace App\Services\Documentation;

use App\Services\Documentation\Knowledge\KnowledgeExporter;

class ProjectBibleService
{
    public function generate(): string
    {
        (new KnowledgeExporter())->export();

        return file_get_contents(
            base_path('docs/generated/PROJECT_BIBLE.md')
        ) ?: '';
    }
}
