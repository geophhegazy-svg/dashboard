<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class AIContextGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function generate(): string
    {
        return implode(PHP_EOL, [

            '# AI Context',

            '',

            'Project Name',

            'EgyptNet ISP Management System',

            '',

            'Technology Stack',

            '- Laravel 13',

            '- PHP 8.4',

            '- Docker',

            '- MySQL',

            '- MikroTik RouterOS API',

            '',

            'Architecture',

            '- Enterprise Architecture',

            '- Service Layer',

            '- Repository Pattern',

            '- Documentation Engine',

            '- Reflection Engine',

            '',

            'Implemented Modules',

            '- Customers',

            '- Packages',

            '- Subscriptions',

            '- Billing',

            '- Invoices',

            '- Payments',

            '- Wallet',

            '- Dashboard',

            '- Notifications',

            '- Inventory',

            '- Tickets',

            '',

            'Documentation',

            '- ProjectScanner',

            '- ReflectionEngine',

            '- MarkdownBuilder',

            '- DocumentationWriter',

            '- DocumentationGenerators',

            '',

            'Development Rules',

            '- Never bypass the Service Layer.',

            '- Reuse existing services whenever possible.',

            '- Keep Enterprise Architecture intact.',

            '- Keep tests passing.',

            '- Update generated documentation after structural changes.',

            '',

            'Current Statistics',

            'Models: ' . count($this->scanner->models()),

            'Services: ' . count($this->scanner->services()),

        ]);
    }

    public function filename(): string
    {
        return 'AI_CONTEXT.md';
    }
}
