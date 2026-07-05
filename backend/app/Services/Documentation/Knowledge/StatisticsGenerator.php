<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class StatisticsGenerator implements KnowledgeGeneratorInterface
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function generate(): string
    {
        $models = count($this->scanner->models());
        $services = count($this->scanner->services());

        return implode(PHP_EOL, [
            '# Project Statistics',
            '',
            "Models: {$models}",
            "Services: {$services}",
        ]);
    }

    public function filename(): string
    {
        return 'STATISTICS.md';
    }
}
