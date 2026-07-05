<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class KnowledgeGeneratorRegistry
{
    /**
     * @return array<KnowledgeGeneratorInterface>
     */
    public function generators(): array
    {
        $scanner = new ProjectScanner();

        return [

            new ProjectSummaryGenerator($scanner),

            new StatisticsGenerator($scanner),

            new ArchitectureGenerator(),

            new AIContextGenerator($scanner),

            new BusinessRulesGenerator(
                $scanner,
                new BusinessRuleExtractor(),
            ),

        ];
    }
}
