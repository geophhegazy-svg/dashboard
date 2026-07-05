<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Writer\DocumentationWriter;

class KnowledgeExporter
{
    public function export(): void
    {
        $manager = new KnowledgeGeneratorManager(
            new KnowledgeGeneratorRegistry(),
            new DocumentationWriter(),
        );

        $manager->generate();
    }
}
