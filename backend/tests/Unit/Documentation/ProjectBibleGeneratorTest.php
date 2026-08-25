<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Modules\Documentation\Application\Knowledge\ProjectBibleGenerator;
use Tests\TestCase;

class ProjectBibleGeneratorTest extends TestCase
{
    public function test_generates_current_project_bible(): void
    {
        $generator = new ProjectBibleGenerator();

        $markdown = $generator->generate();

        $this->assertStringContainsString(
            '# EgyptNet ISP Project Bible',
            $markdown
        );

        $this->assertStringContainsString(
            '## Models',
            $markdown
        );

        $this->assertStringContainsString(
            '## Services',
            $markdown
        );

        $this->assertStringContainsString(
            '## Controllers',
            $markdown
        );

        $this->assertStringNotContainsString(
            'Count: 16',
            $markdown
        );
    }
}
