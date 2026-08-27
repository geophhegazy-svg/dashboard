<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Documentation\Application\Knowledge\AIContextGenerator;
use App\Modules\Documentation\Application\Knowledge\ArchitectureGenerator;
use App\Modules\Documentation\Application\Knowledge\BusinessRulesGenerator;
use App\Modules\Documentation\Application\Knowledge\ControllersKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\DatabaseKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\DependencyGraphKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\HandoverDocumentGenerator;
use App\Modules\Documentation\Application\Knowledge\KnowledgeIndexGenerator;
use App\Modules\Documentation\Application\Knowledge\KnowledgeGeneratorRegistry;
use App\Modules\Documentation\Application\Knowledge\DocumentationKnowledgeGeneratorRegistry;
use App\Modules\Documentation\Application\Knowledge\MigrationsKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\ModelRelationsKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\ModelsKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\ModulesKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\ProjectBibleGenerator;
use App\Modules\Documentation\Application\Knowledge\ProjectStateKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\ProjectSummaryGenerator;
use App\Modules\Documentation\Application\Knowledge\RoutesKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\ServicesKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\ServiceUsageKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\StatisticsGenerator;
use App\Modules\Documentation\Application\Knowledge\TodoKnowledgeGenerator;

final class DocumentationModule extends Module
{
    public function name(): string
    {
        return 'Documentation';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->singletons([

                AIContextGenerator::class
                    => AIContextGenerator::class,

                ProjectSummaryGenerator::class
                    => ProjectSummaryGenerator::class,

                ArchitectureGenerator::class
                    => ArchitectureGenerator::class,

                StatisticsGenerator::class
                    => StatisticsGenerator::class,

                BusinessRulesGenerator::class
                    => BusinessRulesGenerator::class,

                ModelsKnowledgeGenerator::class
                    => ModelsKnowledgeGenerator::class,

                ServicesKnowledgeGenerator::class
                    => ServicesKnowledgeGenerator::class,

                ControllersKnowledgeGenerator::class
                    => ControllersKnowledgeGenerator::class,

                RoutesKnowledgeGenerator::class
                    => RoutesKnowledgeGenerator::class,

                ServiceUsageKnowledgeGenerator::class
                    => ServiceUsageKnowledgeGenerator::class,

                ModelRelationsKnowledgeGenerator::class
                    => ModelRelationsKnowledgeGenerator::class,

                DependencyGraphKnowledgeGenerator::class
                    => DependencyGraphKnowledgeGenerator::class,

                DatabaseKnowledgeGenerator::class
                    => DatabaseKnowledgeGenerator::class,

                MigrationsKnowledgeGenerator::class
                    => MigrationsKnowledgeGenerator::class,

                ModulesKnowledgeGenerator::class
                    => ModulesKnowledgeGenerator::class,

                ProjectStateKnowledgeGenerator::class
                    => ProjectStateKnowledgeGenerator::class,

                ProjectBibleGenerator::class
                    => ProjectBibleGenerator::class,

                HandoverDocumentGenerator::class
                    => HandoverDocumentGenerator::class,

                TodoKnowledgeGenerator::class
                    => TodoKnowledgeGenerator::class,

                KnowledgeIndexGenerator::class
                    => KnowledgeIndexGenerator::class,

            ])

            ->services([
                KnowledgeGeneratorRegistry::class
                    => DocumentationKnowledgeGeneratorRegistry::class,
            ]);
    }
}
