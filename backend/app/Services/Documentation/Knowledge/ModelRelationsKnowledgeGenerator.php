<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class ModelRelationsKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ModelRelationExtractor $extractor = new ModelRelationExtractor()
    ) {}

    public function filename(): string
    {
        return 'MODEL_RELATIONS.md';
    }

    public function generate(): string
    {
        $models = $this->extractor->extract();

        $markdown = [];

        $markdown[] = '# Model Relations';
        $markdown[] = '';

        foreach ($models as $model) {

            $markdown[] = '## ' . $model['model'];
            $markdown[] = '';

            $markdown[] = '**Class**';
            $markdown[] = '';
            $markdown[] = '```';
            $markdown[] = $model['class'];
            $markdown[] = '```';
            $markdown[] = '';

            if (! empty($model['relations'])) {

                $markdown[] = '**Relations**';
                $markdown[] = '';

                foreach ($model['relations'] as $relation) {
                    $markdown[] = '- ' . $relation;
                }

                $markdown[] = '';
            }
        }

        return implode(PHP_EOL, $markdown);
    }
}
