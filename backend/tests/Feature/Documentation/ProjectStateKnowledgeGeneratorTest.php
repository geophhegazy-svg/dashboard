<?php

declare(strict_types=1);

namespace Tests\Feature\Documentation;

use App\Services\Documentation\Knowledge\ProjectStateKnowledgeGenerator;
use Tests\TestCase;

class ProjectStateKnowledgeGeneratorTest extends TestCase
{
    public function test_generates_project_state(): void
    {
        $generator = new ProjectStateKnowledgeGenerator();

        $markdown = $generator->generate();

        $this->assertStringContainsString('# Current Project State', $markdown);
    }
}
