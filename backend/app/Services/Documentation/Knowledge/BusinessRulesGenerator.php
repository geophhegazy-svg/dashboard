<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class BusinessRulesGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner,
        protected BusinessRuleExtractor $extractor,
    ) {}

    public function filename(): string
    {
        return 'BUSINESS_RULES.md';
    }

    public function generate(): string
    {
        $markdown = [];

        $markdown[] = '# Business Rules';
        $markdown[] = '';

        foreach ($this->scanner->services() as $service) {

            $rule = $this->extractor->extract($service);

            $markdown[] = "## {$rule['class']}";
            $markdown[] = '';

            $markdown[] = "**Namespace**";
            $markdown[] = $rule['namespace'];
            $markdown[] = '';

            $markdown[] = '**Dependencies**';

            if (empty($rule['dependencies'])) {
                $markdown[] = '- None';
            } else {
                foreach ($rule['dependencies'] as $dependency) {
                    $markdown[] = "- {$dependency}";
                }
            }

            $markdown[] = '';

            $markdown[] = '**Methods**';

            foreach ($rule['methods'] as $method) {

                $return = $method['return_type'] ?? 'mixed';

                $markdown[] =
                    "- {$method['name']}({$method['parameters']} params) : {$return}";
            }

            $markdown[] = '';
            $markdown[] = '---';
            $markdown[] = '';
        }

        return implode(PHP_EOL, $markdown);
    }
}
