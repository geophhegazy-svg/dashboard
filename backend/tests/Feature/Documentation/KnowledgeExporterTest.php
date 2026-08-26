<?php

declare(strict_types=1);

namespace Tests\Feature\Documentation;

use App\Modules\Documentation\Application\Knowledge\KnowledgeExporter;
use Tests\TestCase;

class KnowledgeExporterTest extends TestCase
{
    public function test_exports_all_documents(): void
    {
        $exporter = app(KnowledgeExporter::class);

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

        $this->assertFileExists(
            base_path('docs/generated/ai/AI_START_PROMPT.md')
        );
    }
}
