<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Writer\DocumentationWriter;

class KnowledgeExporter
{
    public function __construct(
        protected DocumentationWriter $writer = new DocumentationWriter()
    ) {}

    public function export(): void
    {
        $registry = new KnowledgeGeneratorRegistry();

        foreach ($registry->generators() as $generator) {
            $this->writer->write(
                $generator->filename(),
                $generator->generate()
            );
        }

        $this->exportAiFiles();
    }

    protected function exportAiFiles(): void
    {
        $directory = base_path('docs/generated/ai');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents(
            $directory . '/AI_START_PROMPT.md',
            $this->buildStartPrompt()
        );
    }

    protected function buildStartPrompt(): string
    {
        return <<<MARKDOWN
# AI START PROMPT

This project contains a self-generated documentation system.

Before making any modification, read the documentation under:

docs/generated/

Especially:

- PROJECT_SUMMARY.md
- PROJECT_STATE.md
- ARCHITECTURE.md
- MODULES.md
- BUSINESS_RULES.md
- ROUTES.md
- SERVICES.md
- MODELS.md
- DATABASE.md
- TODO.md
- HANDOVER.md

These documents are generated automatically using:

php artisan bible:update

Always consider them as the primary source of truth for the project.
MARKDOWN;
    }
}
