<?php

declare(strict_types=1);

namespace App\Services\Documentation;

use App\Services\Documentation\Generators\ActionDocumentationGenerator;
use App\Services\Documentation\Generators\ControllerDocumentationGenerator;
use App\Services\Documentation\Generators\ModelDocumentationGenerator;
use App\Services\Documentation\Generators\RepositoryDocumentationGenerator;
use App\Services\Documentation\Generators\ServiceDocumentationGenerator;
use App\Services\Documentation\Manager\DocumentationGeneratorManager;
use App\Services\Documentation\Registry\DocumentationGeneratorRegistry;
use App\Services\Documentation\Scanner\ProjectScanner;
use App\Services\Documentation\Writer\DocumentationWriter;
use App\Services\Documentation\Knowledge\KnowledgeExporter;

class ProjectBibleService
{
    public function generate(): string
    {
        $scanner = new ProjectScanner();

        $registry = new DocumentationGeneratorRegistry();

        $registry
            ->register(new ModelDocumentationGenerator($scanner))
            ->register(new ServiceDocumentationGenerator($scanner))
            ->register(new ControllerDocumentationGenerator($scanner))
            ->register(new RepositoryDocumentationGenerator($scanner))
            ->register(new ActionDocumentationGenerator($scanner));

        $manager = new DocumentationGeneratorManager(
            $registry,
            new DocumentationWriter()
        );

        $manager->generate();

        (new KnowledgeExporter())->export();

        return file_get_contents(
            base_path('docs/generated/PROJECT_BIBLE.md')
        ) ?: '';
    }
}
