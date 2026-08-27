<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Modules\Documentation\Application\Knowledge\AIContextGenerator;
use App\Modules\Documentation\Application\Knowledge\ArchitectureGenerator;
use App\Modules\Documentation\Application\Knowledge\BusinessRulesGenerator;
use App\Modules\Documentation\Application\Knowledge\ControllersKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\DatabaseKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\DependencyGraphKnowledgeGenerator;
use App\Modules\Documentation\Application\Knowledge\DocumentationKnowledgeGeneratorRegistry;
use App\Modules\Documentation\Application\Knowledge\HandoverDocumentGenerator;
use App\Modules\Documentation\Application\Knowledge\KnowledgeGeneratorInterface;
use App\Modules\Documentation\Application\Knowledge\KnowledgeGeneratorRegistry;
use App\Modules\Documentation\Application\Knowledge\KnowledgeIndexGenerator;
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
use Tests\TestCase;

final class KnowledgeGeneratorRegistryTest extends TestCase
{
    public function test_registry_can_register_a_generator(): void
    {
        $generator = $this->createMock(
            KnowledgeGeneratorInterface::class
        );

        $registry = new KnowledgeGeneratorRegistry();

        $registry->register($generator);

        self::assertSame(
            [$generator],
            $registry->generators()
        );
    }

    public function test_documentation_registry_contains_all_generators(): void
    {
        $registry = new DocumentationKnowledgeGeneratorRegistry(
            new AIContextGenerator(),
            new ProjectSummaryGenerator(),
            new ArchitectureGenerator(),
            new StatisticsGenerator(
                new \App\Modules\Documentation\Application\Scanner\ProjectScanner()
            ),
            new BusinessRulesGenerator(
                new \App\Modules\Documentation\Application\Scanner\ProjectScanner(),
                new \App\Modules\Documentation\Application\Knowledge\BusinessRuleExtractor()
            ),
            new ModelsKnowledgeGenerator(
                new \App\Modules\Documentation\Application\Scanner\ProjectScanner()
            ),
            new ServicesKnowledgeGenerator(
                new \App\Modules\Documentation\Application\Scanner\ProjectScanner()
            ),
            new ControllersKnowledgeGenerator(
                new \App\Modules\Documentation\Application\Scanner\ProjectScanner()
            ),
            new RoutesKnowledgeGenerator(),
            new ServiceUsageKnowledgeGenerator(),
            new ModelRelationsKnowledgeGenerator(),
            new DependencyGraphKnowledgeGenerator(),
            new DatabaseKnowledgeGenerator(),
            new MigrationsKnowledgeGenerator(),
            new ModulesKnowledgeGenerator(),
            new ProjectStateKnowledgeGenerator(),
            new ProjectBibleGenerator(),
            new HandoverDocumentGenerator(),
            new TodoKnowledgeGenerator(),
            new KnowledgeIndexGenerator(),
        );

        $generators = $registry->generators();

        self::assertCount(20, $generators);

        foreach ($generators as $generator) {
            self::assertInstanceOf(
                KnowledgeGeneratorInterface::class,
                $generator
            );
        }

        self::assertSame(
            [
                AIContextGenerator::class,
                ProjectSummaryGenerator::class,
                ArchitectureGenerator::class,
                StatisticsGenerator::class,
                BusinessRulesGenerator::class,
                ModelsKnowledgeGenerator::class,
                ServicesKnowledgeGenerator::class,
                ControllersKnowledgeGenerator::class,
                RoutesKnowledgeGenerator::class,
                ServiceUsageKnowledgeGenerator::class,
                ModelRelationsKnowledgeGenerator::class,
                DependencyGraphKnowledgeGenerator::class,
                DatabaseKnowledgeGenerator::class,
                MigrationsKnowledgeGenerator::class,
                ModulesKnowledgeGenerator::class,
                ProjectStateKnowledgeGenerator::class,
                ProjectBibleGenerator::class,
                HandoverDocumentGenerator::class,
                TodoKnowledgeGenerator::class,
                KnowledgeIndexGenerator::class,
            ],
            array_map(
                static fn ($generator) => $generator::class,
                $generators
            )
        );
    }

    public function test_container_resolves_documentation_registry(): void
    {
        $registry = app(KnowledgeGeneratorRegistry::class);

        self::assertInstanceOf(
            DocumentationKnowledgeGeneratorRegistry::class,
            $registry
        );

        self::assertCount(
            20,
            $registry->generators()
        );
    }
}
