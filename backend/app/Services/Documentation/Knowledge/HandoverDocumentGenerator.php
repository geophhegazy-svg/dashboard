<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Handover\ExecutiveSummarySection;

class HandoverDocumentGenerator implements KnowledgeGeneratorInterface
{
    public function filename(): string
    {
        return 'HANDOVER.md';
    }

    public function generate(): string
    {
        $markdown = [];

        $markdown[] = '# PROJECT HANDOVER DOCUMENT';
        $markdown[] = '';

        /*
        |--------------------------------------------------------------------------
        | Handover Sections
        |--------------------------------------------------------------------------
        |
        | سنستبدل ملفات append() تدريجياً بهذه الـ Sections.
        |
        */

        $sections = [
            new ExecutiveSummarySection(),
        ];

        foreach ($sections as $section) {
            $markdown[] = $section->generate();
        }

        /*
        |--------------------------------------------------------------------------
        | Legacy Generated Documents
        |--------------------------------------------------------------------------
        |
        | مؤقتاً نضيف الملفات القديمة حتى ننتهي من تحويلها إلى Sections.
        |
        */

        $this->append($markdown, 'ARCHITECTURE.md');
        $this->append($markdown, 'STATISTICS.md');
        $this->append($markdown, 'AI_CONTEXT.md');
        $this->append($markdown, 'BUSINESS_RULES.md');
        $this->append($markdown, 'MODELS_FULL.md');
        $this->append($markdown, 'SERVICES_FULL.md');
        $this->append($markdown, 'CONTROLLERS_FULL.md');
        $this->append($markdown, 'ROUTES_FULL.md');

        return implode(PHP_EOL, $markdown);
    }

    protected function append(array &$markdown, string $file): void
    {
        $path = base_path('docs/generated/' . $file);

        if (! file_exists($path)) {
            return;
        }

        $markdown[] = '';
        $markdown[] = '---';
        $markdown[] = '';

        $markdown[] = trim(file_get_contents($path));
    }
}
