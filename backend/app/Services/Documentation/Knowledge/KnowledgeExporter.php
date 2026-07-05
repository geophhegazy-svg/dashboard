<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Writer\DocumentationWriter;

class KnowledgeExporter
{
    public function __construct(
        protected DocumentationWriter $writer = new DocumentationWriter()
    ) {}

    public function export(): void
    {
        $documents = [

            'AI_CONTEXT.md' => (new AIContextGenerator())->generate(),

            'PROJECT_SUMMARY.md' => (new ProjectSummaryGenerator())->generate(),

            'ARCHITECTURE.md' => (new ArchitectureGenerator())->generate(),

            'STATISTICS.md' => (new StatisticsGenerator())->generate(),

        ];

        foreach ($documents as $filename => $markdown) {
            $this->writer->write($filename, $markdown);
        }
    }
}
