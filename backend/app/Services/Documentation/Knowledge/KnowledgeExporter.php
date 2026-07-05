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
        $registry = new KnowledgeGeneratorRegistry();

        foreach ($registry->generators() as $generator) {

            $this->writer->write(
                $generator->filename(),
                $generator->generate()
            );
        }
    }
}
