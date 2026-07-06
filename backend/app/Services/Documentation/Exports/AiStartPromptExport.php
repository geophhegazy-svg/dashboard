<?php

declare(strict_types=1);

namespace App\Services\Documentation\Exports;

class AiStartPromptExport implements ExportInterface
{
    public function filename(): string
    {
        return 'AI_START_PROMPT.md';
    }

    public function content(): string
    {
        return <<<MD
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
MD;
    }

    public function isAiExport(): bool
    {
        return true;
    }
}
