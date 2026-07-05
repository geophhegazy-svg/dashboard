<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Reflection\ReflectionEngine;
use App\Services\Documentation\Scanner\ProjectScanner;

class ModelsKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner,
        protected ?ReflectionEngine $reflection = null,
    ) {
        $this->reflection ??= new ReflectionEngine();
    }

    public function filename(): string
    {
        return 'MODELS_FULL.md';
    }

    public function generate(): string
    {
        $markdown = [];

        $markdown[] = '# Models';
        $markdown[] = '';

        $models = $this->scanner->models();

        foreach ($models as $model) {

            $markdown[] = '---';
            $markdown[] = '';

            $markdown[] = '## ' . $model['name'];
            $markdown[] = '';

            if (! empty($model['namespace'])) {
                $markdown[] = '**Namespace**';
                $markdown[] = '';
                $markdown[] = '```';
                $markdown[] = $model['namespace'];
                $markdown[] = '```';
                $markdown[] = '';
            }

            if (! empty($model['path'])) {
                $markdown[] = '**File**';
                $markdown[] = '';
                $markdown[] = '```';
                $markdown[] = $model['path'];
                $markdown[] = '```';
                $markdown[] = '';
            }

            if (! empty($model['class'])) {

                $reflection = $this->reflection->reflect($model['class']);

                if (! empty($reflection['parent'])) {
                    $markdown[] = '**Extends**';
                    $markdown[] = '';
                    $markdown[] = '- ' . $reflection['parent'];
                    $markdown[] = '';
                }

                if (! empty($reflection['traits'])) {

                    $markdown[] = '**Traits**';
                    $markdown[] = '';

                    foreach ($reflection['traits'] as $trait) {
                        $markdown[] = '- ' . $trait;
                    }

                    $markdown[] = '';
                }

                if (! empty($reflection['properties'])) {

                    $markdown[] = '**Properties**';
                    $markdown[] = '';

                    foreach ($reflection['properties'] as $property) {

                        $markdown[] =
                            '- $' . $property['name'] .
                            ' : ' . $property['type'];
                    }

                    $markdown[] = '';
                }

                if (! empty($reflection['methods'])) {

                    $markdown[] = '**Methods**';
                    $markdown[] = '';

                    foreach ($reflection['methods'] as $method) {

                        $markdown[] =
                            '- ' . $method['name'] . '()';
                    }

                    $markdown[] = '';
                }
            }
        }

        return implode(PHP_EOL, $markdown);
    }
}
