<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Knowledge\AIContextGenerator;
use Tests\TestCase;

class AIContextGeneratorTest extends TestCase
{
    public function test_generates_ai_context(): void
    {
        $generator = new AIContextGenerator();

        $markdown = $generator->generate();

        $this->assertStringContainsString(
            '# AI Context',
            $markdown
        );

        $this->assertStringContainsString(
            'EgyptNet ISP Management System',
            $markdown
        );

        $this->assertStringContainsString(
            'Enterprise Architecture',
            $markdown
        );

        $this->assertStringContainsString(
            'Service Layer',
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
