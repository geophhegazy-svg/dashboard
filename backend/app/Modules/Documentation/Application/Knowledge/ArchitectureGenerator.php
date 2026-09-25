<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Knowledge;

class ArchitectureGenerator implements KnowledgeGeneratorInterface
{
    public function generate(): string
    {
        return implode(PHP_EOL, [
            '# Project Architecture',
            '',
            'EgyptNet Enterprise ISP Platform',
            '',
            '## Architectural Layers',
            '',
            '- Core Platform',
            '- Modules',
            '- Infrastructure',
            '- Presentation',
            '',
            '## Application Layering',
            '',
            '- Presentation',
            '- Application',
            '- Domain',
            '- Infrastructure',
            '',
            '## Core',
            '',
            '- Kernel',
            '- Command Bus',
            '- Query Bus',
            '- Action Bus',
            '- Event Bus',
            '- Workflow Engine',
            '- Security / Authorization',
            '- Tenancy',
            '',
            '## Module Structure',
            '',
            'Each business module follows the bounded structure:',
            '',
            '```text',
            'Module/',
            '├── Application/',
            '├── Domain/',
            '├── Infrastructure/',
            '└── Kernel/',
            '```',
            '',
            'Presentation and other module-specific surfaces are added only where required by the module.',
            '',
            '## Runtime Registration',
            '',
            'Module discovery and registration are owned by the Kernel registration pipeline.',
            '',
            'Documentation generation is owned by the Documentation Module.',
        ]);
    }

    public function filename(): string
    {
        return 'ARCHITECTURE.md';
    }
}
