<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Reflection\ReflectionEngine;
use App\Services\Documentation\Scanner\ProjectScanner;

class ServicesKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner,
        protected ?ReflectionEngine $reflection = null,
    ) {
        $this->reflection ??= new ReflectionEngine();
    }

    public function filename(): string
    {
        return 'SERVICES_FULL.md';
    }

    public function generate(): string
    {
        $markdown = [];

        $markdown[] = '# Services';
        $markdown[] = '';

        $services = $this->scanner->services();

        foreach ($services as $service) {

            $markdown[] = '---';
            $markdown[] = '';

            $markdown[] = '## ' . $service['name'];
            $markdown[] = '';

            if (! empty($service['namespace'])) {
                $markdown[] = '**Namespace**';
                $markdown[] = '';
                $markdown[] = '```';
                $markdown[] = $service['namespace'];
                $markdown[] = '```';
                $markdown[] = '';
            }

            if (! empty($service['path'])) {
                $markdown[] = '**File**';
                $markdown[] = '';
                $markdown[] = '```';
                $markdown[] = $service['path'];
                $markdown[] = '```';
                $markdown[] = '';
            }

            if (! empty($service['class'])) {

                $reflection = $this->reflection->reflect($service['class']);

                if (! empty($reflection['constructor'])) {

                    $markdown[] = '**Constructor Dependencies**';
                    $markdown[] = '';

                    foreach ($reflection['constructor'] as $dependency) {

                        $type = class_basename($dependency['type']);

                        $markdown[] =
                            '- ' .
                            $type .
                            ' $' .
                            $dependency['name'];
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

                        $line = '- ' . $method['name'] . '()';

                        if (! empty($method['return'])) {
                            $line .= ' : ' . $method['return'];
                        }

                        $markdown[] = $line;
                    }

                    $markdown[] = '';
                }
            }
        }

        return implode(PHP_EOL, $markdown);
    }
}
