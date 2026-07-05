<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Knowledge\ModelsKnowledgeGenerator;
use App\Services\Documentation\Scanner\ProjectScanner;
use Tests\TestCase;

class ModelsKnowledgeGeneratorTest extends TestCase
{
    public function test_generates_models_documentation(): void
    {
        $generator = new ModelsKnowledgeGenerator(
            new ProjectScanner()
        );

        $markdown = $generator->generate();

        $this->assertStringContainsString(
            '# Models',
            $markdown
        );

        $this->assertNotEmpty($markdown);
    }
}
