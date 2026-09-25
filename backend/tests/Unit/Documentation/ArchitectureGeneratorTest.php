<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Modules\Documentation\Application\Knowledge\ArchitectureGenerator;
use PHPUnit\Framework\TestCase;

class ArchitectureGeneratorTest extends TestCase
{
    public function test_generates_architecture(): void
    {
        $generator = new ArchitectureGenerator();

        $markdown = $generator->generate();

        $this->assertStringContainsString(
            '# Project Architecture',
            $markdown
        );

        $this->assertStringContainsString(
            'Application Layering',
            $markdown
        );

        $this->assertStringContainsString(
            'Documentation',
            $markdown
        );

        $this->assertStringContainsString(
            'Module Structure',
            $markdown
        );
    }
}
