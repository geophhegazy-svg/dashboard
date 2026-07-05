<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Knowledge\ProjectSummaryGenerator;
use Tests\TestCase;

class ProjectSummaryGeneratorTest extends TestCase
{
    public function test_generates_project_summary(): void
    {
        $generator = new ProjectSummaryGenerator();

        $markdown = $generator->generate();

        $this->assertStringContainsString(
            'EgyptNet ISP Management System',
            $markdown
        );

        $this->assertStringContainsString(
            'Laravel 13',
            $markdown
        );

        $this->assertStringContainsString(
            'Models:',
            $markdown
        );

        $this->assertStringContainsString(
            'Services:',
            $markdown
        );
    }
}
