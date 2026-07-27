<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Modules\Documentation\Application\Knowledge\BusinessRuleExtractor;
use App\Modules\Documentation\Application\Knowledge\BusinessRulesGenerator;
use App\Modules\Documentation\Application\Scanner\ProjectScanner;
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
