<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class KnowledgeGeneratorRegistry
{
    /**
     * @var KnowledgeGeneratorInterface[]
     */
    protected array $generators = [];

    public function __construct(?ProjectScanner $scanner = null)
    {
        $scanner ??= new ProjectScanner();

        $this->register(
            new AIContextGenerator($scanner)
        );

        $this->register(
            new ProjectSummaryGenerator($scanner)
        );

        $this->register(
            new ArchitectureGenerator($scanner)
        );

        $this->register(
            new StatisticsGenerator($scanner)
        );

        $this->register(
            new BusinessRulesGenerator(
                $scanner,
                new BusinessRuleExtractor()
            )
        );

        $this->register(
            new ModelsKnowledgeGenerator($scanner)
        );

        $this->register(
            new ServicesKnowledgeGenerator($scanner)
        );

        $this->register(
            new ControllersKnowledgeGenerator($scanner)
        );

        $this->register(
            new RoutesKnowledgeGenerator()
        );

        $this->register(
            new ServiceUsageKnowledgeGenerator()
        );

        $this->register(
            new ModelRelationsKnowledgeGenerator()
        );

        $this->register(
            new DependencyGraphKnowledgeGenerator()
        );

        $this->register(
            new DatabaseKnowledgeGenerator()
        );

        $this->register(
            new MigrationsKnowledgeGenerator()
        );

        $this->register(
            new ModulesKnowledgeGenerator()
        );

        $this->register(
            new ProjectStateKnowledgeGenerator()
        );

        $this->register(
            new HandoverDocumentGenerator()
        );

        $this->register(
            new TodoKnowledgeGenerator()
        );

        $this->register(
            new KnowledgeIndexGenerator()
        );
    }

    public function register(
        KnowledgeGeneratorInterface $generator
    ): self {
        $this->generators[] = $generator;

        return $this;
    }

    /**
     * @return KnowledgeGeneratorInterface[]
     */
    public function generators(): array
    {
        return $this->generators;
    }
}
