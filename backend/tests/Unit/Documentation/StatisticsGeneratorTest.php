<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Knowledge\StatisticsGenerator;
use Tests\TestCase;

class StatisticsGeneratorTest extends TestCase
{
    public function test_generates_statistics(): void
    {
        $generator = new StatisticsGenerator();

        $markdown = $generator->generate();

        $this->assertStringContainsString(
            '# Project Statistics',
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
