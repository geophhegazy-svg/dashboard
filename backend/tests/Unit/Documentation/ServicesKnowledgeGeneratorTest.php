<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Modules\Documentation\Application\Knowledge\ServicesKnowledgeGenerator;
use App\Modules\Documentation\Application\Scanner\ProjectScanner;
use Tests\TestCase;

class ServicesKnowledgeGeneratorTest extends TestCase
{
    public function test_generates_services_documentation(): void
    {
        $generator = new ServicesKnowledgeGenerator(
            new ProjectScanner()
        );

        $markdown = $generator->generate();

        $this->assertStringContainsString(
            '# Services',
            $markdown
        );

        $this->assertNotEmpty($markdown);
    }
}
