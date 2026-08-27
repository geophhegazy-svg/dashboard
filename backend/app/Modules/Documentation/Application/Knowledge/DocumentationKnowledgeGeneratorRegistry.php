<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Knowledge;

final class DocumentationKnowledgeGeneratorRegistry extends KnowledgeGeneratorRegistry
{
    public function __construct(
        AIContextGenerator $aiContext,
        ProjectSummaryGenerator $projectSummary,
        ArchitectureGenerator $architecture,
        StatisticsGenerator $statistics,
        BusinessRulesGenerator $businessRules,
        ModelsKnowledgeGenerator $models,
        ServicesKnowledgeGenerator $services,
        ControllersKnowledgeGenerator $controllers,
        RoutesKnowledgeGenerator $routes,
        ServiceUsageKnowledgeGenerator $serviceUsage,
        ModelRelationsKnowledgeGenerator $modelRelations,
        DependencyGraphKnowledgeGenerator $dependencyGraph,
        DatabaseKnowledgeGenerator $database,
        MigrationsKnowledgeGenerator $migrations,
        ModulesKnowledgeGenerator $modules,
        ProjectStateKnowledgeGenerator $projectState,
        ProjectBibleGenerator $projectBible,
        HandoverDocumentGenerator $handover,
        TodoKnowledgeGenerator $todo,
        KnowledgeIndexGenerator $knowledgeIndex,
    ) {
        parent::__construct(
            $aiContext,
            $projectSummary,
            $architecture,
            $statistics,
            $businessRules,
            $models,
            $services,
            $controllers,
            $routes,
            $serviceUsage,
            $modelRelations,
            $dependencyGraph,
            $database,
            $migrations,
            $modules,
            $projectState,
            $projectBible,
            $handover,
            $todo,
            $knowledgeIndex,
        );
    }
}
