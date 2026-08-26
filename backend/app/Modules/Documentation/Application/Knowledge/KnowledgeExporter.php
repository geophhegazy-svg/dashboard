<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Knowledge;

use App\Modules\Documentation\Application\Exports\ExportRegistry;
use App\Modules\Documentation\Application\Writer\DocumentationWriter;

class KnowledgeExporter
{
    public function __construct(
        protected KnowledgeGeneratorManager $generatorManager,
        protected ExportRegistry $exportRegistry,
        protected DocumentationWriter $writer,
    ) {}

    public function export(): void
    {
        $this->generatorManager->generate();

        foreach ($this->exportRegistry->exports() as $export) {
            if (! $export->isAiExport()) {
                continue;
            }

            $this->writeAiExport(
                $export->filename(),
                $export->content()
            );
        }
    }

    protected function writeAiExport(
        string $filename,
        string $contents
    ): void {
        $this->writer->write(
            'ai/' . $filename,
            $contents
        );
    }
}
