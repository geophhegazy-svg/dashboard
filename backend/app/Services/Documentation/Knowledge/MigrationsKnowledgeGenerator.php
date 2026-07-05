<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class MigrationsKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected MigrationExtractor $extractor = new MigrationExtractor()
    ) {}

    public function filename(): string
    {
        return 'MIGRATIONS.md';
    }

    public function generate(): string
    {
        $migrations = $this->extractor->extract();

        $markdown = [];

        $markdown[] = '# Database Migrations';
        $markdown[] = '';

        foreach ($migrations as $migration) {

            $markdown[] = '## ' . $migration['name'];
            $markdown[] = '';

            $markdown[] = '**File**';
            $markdown[] = '';
            $markdown[] = '```';
            $markdown[] = $migration['path'];
            $markdown[] = '```';
            $markdown[] = '';
        }

        return implode(PHP_EOL, $markdown);
    }
}
