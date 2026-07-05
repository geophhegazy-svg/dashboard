<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class ServiceUsageKnowledgeGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ServiceUsageExtractor $extractor = new ServiceUsageExtractor()
    ) {}

    public function filename(): string
    {
        return 'SERVICE_USAGE.md';
    }

    public function generate(): string
    {
        $services = $this->extractor->extract();

        $markdown = [];

        $markdown[] = '# Service Usage';
        $markdown[] = '';

        foreach ($services as $service) {

            $markdown[] = '## ' . $service['service'];
            $markdown[] = '';

            $markdown[] = '**Class**';
            $markdown[] = '';
            $markdown[] = '```';
            $markdown[] = $service['class'];
            $markdown[] = '```';
            $markdown[] = '';

            if (! empty($service['methods'])) {

                $markdown[] = '**Public Methods**';
                $markdown[] = '';

                foreach ($service['methods'] as $method) {
                    $markdown[] = '- ' . $method;
                }

                $markdown[] = '';
            }
        }

        return implode(PHP_EOL, $markdown);
    }
}
