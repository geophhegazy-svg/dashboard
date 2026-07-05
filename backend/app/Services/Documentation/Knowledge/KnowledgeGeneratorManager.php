<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Writer\DocumentationWriter;

class KnowledgeGeneratorManager
{
    public function __construct(
        protected KnowledgeGeneratorRegistry $registry,
        protected DocumentationWriter $writer,
    ) {}

    public function generate(): void
    {
        foreach ($this->registry->generators() as $generator) {

            $this->writer->write(

                $generator->filename(),

                $generator->generate()

            );
        }
    }
}
