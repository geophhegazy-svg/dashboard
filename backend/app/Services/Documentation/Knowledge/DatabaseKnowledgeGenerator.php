<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class DatabaseKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected DatabaseExtractor $extractor = new DatabaseExtractor()
    ) {}

    public function filename(): string
    {
        return 'DATABASE.md';
    }

    public function generate(): string
    {
        $database = $this->extractor->extract();

        $markdown = [];

        $markdown[] = '# Database';
        $markdown[] = '';

        foreach ($database as $table) {

            $markdown[] = '## ' . $table['table'];
            $markdown[] = '';

            if (isset($table['count'])) {
                $markdown[] = '**Rows:** ' . $table['count'];
                $markdown[] = '';
            }

            if (! empty($table['columns'])) {

                $markdown[] = '### Columns';
                $markdown[] = '';

                foreach ($table['columns'] as $column) {

                    $line = '- ' . $column['name'];

                    if (! empty($column['type'])) {
                        $line .= ' (' . $column['type'] . ')';
                    }

                    if (($column['nullable'] ?? false) === true) {
                        $line .= ' nullable';
                    }

                    if (array_key_exists('default', $column) && $column['default'] !== null) {
                        $line .= ' default=' . $column['default'];
                    }

                    $markdown[] = $line;
                }

                $markdown[] = '';
            }

            if (! empty($table['relations'])) {

                $markdown[] = '### Relations';
                $markdown[] = '';

                foreach ($table['relations'] as $relation) {
                    $markdown[] = '- ' . $relation;
                }

                $markdown[] = '';
            }
        }

        return implode(PHP_EOL, $markdown);
    }
}
