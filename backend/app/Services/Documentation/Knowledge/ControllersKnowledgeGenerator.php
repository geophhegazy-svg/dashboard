<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Reflection\ReflectionEngine;
use App\Services\Documentation\Scanner\ProjectScanner;

class ControllersKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner,
        protected ?ReflectionEngine $reflection = null,
    ) {
        $this->reflection ??= new ReflectionEngine();
    }

    public function filename(): string
    {
        return 'CONTROLLERS_FULL.md';
    }

    public function generate(): string
    {
        $markdown = [];

        $markdown[] = '# Controllers';
        $markdown[] = '';

        foreach ($this->scanner->controllers() as $controller) {

            $markdown[] = '---';
            $markdown[] = '';

            $markdown[] = '## ' . $controller['name'];
            $markdown[] = '';

            $markdown[] = '**Namespace**';
            $markdown[] = '';
            $markdown[] = '```';
            $markdown[] = $controller['namespace'];
            $markdown[] = '```';
            $markdown[] = '';

            $markdown[] = '**File**';
            $markdown[] = '';
            $markdown[] = '```';
            $markdown[] = $controller['path'];
            $markdown[] = '```';
            $markdown[] = '';

            if (! empty($controller['class'])) {

                $reflection = $this->reflection->reflect($controller['class']);

                if (! empty($reflection['constructor'])) {

                    $markdown[] = '**Dependencies**';
                    $markdown[] = '';

                    foreach ($reflection['constructor'] as $dependency) {

                        $markdown[] =
                            '- ' .
                            class_basename($dependency['type']) .
                            ' $' .
                            $dependency['name'];
                    }

                    $markdown[] = '';
                }

                if (! empty($reflection['methods'])) {

                    $markdown[] = '**Public Methods**';
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
