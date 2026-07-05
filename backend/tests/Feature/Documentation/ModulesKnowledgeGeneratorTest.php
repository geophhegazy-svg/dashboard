<?php

declare(strict_types=1);

namespace Tests\Feature\Documentation;

use App\Services\Documentation\Knowledge\ModulesKnowledgeGenerator;
use Tests\TestCase;

class ModulesKnowledgeGeneratorTest extends TestCase
{
    public function test_generates_modules_documentation(): void
    {
        $generator = new ModulesKnowledgeGenerator();

        $markdown = $generator->generate();

        $this->assertStringContainsString('# Modules', $markdown);

        $this->assertStringContainsString('Services', $markdown);
    }
}
