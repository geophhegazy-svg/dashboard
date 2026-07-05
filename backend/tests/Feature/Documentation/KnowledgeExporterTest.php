<?php

declare(strict_types=1);

namespace Tests\Feature\Documentation;

use Tests\TestCase;

class KnowledgeExporterTest extends TestCase
{
    public function test_exports_all_documents(): void
    {
        $exporter = new \App\Services\Documentation\Knowledge\KnowledgeExporter();

        $exporter->export();

        $this->assertFileExists(
            base_path('docs/generated/AI_CONTEXT.md')
        );

        $this->assertFileExists(
            base_path('docs/generated/PROJECT_SUMMARY.md')
        );

        $this->assertFileExists(
            base_path('docs/generated/ARCHITECTURE.md')
        );

        $this->assertFileExists(
            base_path('docs/generated/STATISTICS.md')
        );
    }
}
