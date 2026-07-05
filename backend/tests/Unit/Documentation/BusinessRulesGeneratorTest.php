<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Knowledge\BusinessRuleExtractor;
use App\Services\Documentation\Knowledge\BusinessRulesGenerator;
use App\Services\Documentation\Scanner\ProjectScanner;
use Tests\TestCase;

class BusinessRulesGeneratorTest extends TestCase
{
    public function test_generates_business_rules(): void
    {
        $generator = new BusinessRulesGenerator(
            new ProjectScanner(),
            new BusinessRuleExtractor()
        );

        $markdown = $generator->generate();

        $this->assertStringContainsString(
            '# Business Rules',
            $markdown
        );

        $this->assertNotEmpty($markdown);
    }
}
