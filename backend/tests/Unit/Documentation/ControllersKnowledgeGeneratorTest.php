<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Modules\Documentation\Application\Knowledge\ControllersKnowledgeGenerator;
use App\Modules\Documentation\Application\Scanner\ProjectScanner;
use Tests\TestCase;

class ControllersKnowledgeGeneratorTest extends TestCase
{
    public function test_generates_controllers_documentation(): void
    {
        $generator = new ControllersKnowledgeGenerator(
            new ProjectScanner()
        );

        $markdown = $generator->generate();

        $this->assertStringContainsString(
            '# Controllers',
            $markdown
        );

        $this->assertNotEmpty($markdown);
    }
}
