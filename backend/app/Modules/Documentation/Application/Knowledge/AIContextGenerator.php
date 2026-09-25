<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Knowledge;

use App\Modules\Documentation\Application\Scanner\ProjectScanner;

class AIContextGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function generate(): string
    {
        $project = $this->scanner->all();

        return implode(PHP_EOL, [
            '# AI Context',
            '',
            '## Project',
            '',
            'EgyptNet Enterprise ISP Platform',
            '',
            '## Technology Stack',
            '',
            '- Laravel 13',
            '- PHP 8.4',
            '- Docker',
            '- MySQL',
            '- MikroTik RouterOS API',
            '',
            '## Architecture',
            '',
            '- Core Platform',
            '- Module-based business architecture',
            '- Presentation → Application → Domain → Infrastructure',
            '- Kernel-owned module discovery and registration',
            '- Action Bus / Command Bus / Query Bus / Event Bus',
            '- Workflow Engine',
            '- Spatie Permission based authorization',
            '- Tenant-aware business boundaries',
            '',
            '## Documentation',
            '',
            '- Documentation Module',
            '- ProjectScanner',
            '- DocumentationKnowledgeGeneratorRegistry',
            '- KnowledgeGeneratorManager',
            '- DocumentationWriter',
            '- Generated documentation under `docs/generated/`',
            '',
            '## Current Inventory',
            '',
            'Models: ' . count($project['models']),
            'Services: ' . count($project['services']),
            'Controllers: ' . count($project['controllers']),
            'Repositories: ' . count($project['repositories']),
            'Actions: ' . count($project['actions']),
            '',
            '## Development Rules',
            '',
            '- Preserve the established Core → Modules → Infrastructure → Presentation architecture.',
            '- Keep module ownership boundaries explicit.',
            '- Use Actions / Workflows according to the established use-case architecture.',
            '- Do not introduce compatibility adapters without architectural evidence.',
            '- Do not perform speculative refactoring.',
            '- Keep tests passing.',
            '- Regenerate documentation after structural changes.',
        ]);
    }

    public function filename(): string
    {
        return 'AI_CONTEXT.md';
    }
}
