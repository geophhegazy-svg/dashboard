<?php

declare(strict_types=1);

namespace App\Services\Documentation\Manager;

use App\Services\Documentation\Registry\DocumentationGeneratorRegistry;
use App\Services\Documentation\Writer\DocumentationWriter;

class DocumentationGeneratorManager
{
    public function __construct(
        protected DocumentationGeneratorRegistry $registry,
        protected DocumentationWriter $writer
    ) {}

    public function generate(): void
    {
        foreach ($this->registry->all() as $generator) {

            $filename = strtoupper(
                str_replace(
                    'DocumentationGenerator',
                    '',
                    class_basename($generator)
                )
            );

            $this->writer->write(
                $generator->filename(),
                $generator->generate()
            );
        }
    }
}
