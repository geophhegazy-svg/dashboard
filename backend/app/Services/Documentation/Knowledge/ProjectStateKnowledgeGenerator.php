<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class ProjectStateKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ProjectStateExtractor $extractor = new ProjectStateExtractor()
    ) {}

    public function filename(): string
    {
        return 'PROJECT_STATE.md';
    }

    public function generate(): string
    {
        $state = $this->extractor->extract();

        $markdown = [];

        $markdown[] = '# Current Project State';
        $markdown[] = '';

        foreach ($state as $key => $value) {

            $markdown[] = '## ' . ucwords(str_replace('_', ' ', (string) $key));
            $markdown[] = '';

            if (is_array($value)) {

                foreach ($value as $item) {
                    $markdown[] = '- ' . $item;
                }
            } else {

                $markdown[] = (string) $value;
            }

            $markdown[] = '';
        }

        return implode(PHP_EOL, $markdown);
    }
}
