<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Modules\Documentation\Application\Knowledge\AIContextGenerator;
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
            'EgyptNet Enterprise ISP Platform',
            $markdown
        );

        $this->assertStringContainsString(
            'Core Platform',
            $markdown
        );

        $this->assertStringContainsString(
            'Module-based business architecture',
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
