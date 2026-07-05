<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Knowledge\BusinessRuleExtractor;
use App\Services\Documentation\Scanner\ProjectScanner;
use Tests\TestCase;

class BusinessRuleExtractorTest extends TestCase
{
    public function test_extracts_first_service(): void
    {
        $scanner = new ProjectScanner();

        $services = $scanner->services();

        $this->assertNotEmpty($services);

        $extractor = new BusinessRuleExtractor();

        $result = $extractor->extract($services[0]);

        $this->assertArrayHasKey('class', $result);
        $this->assertArrayHasKey('namespace', $result);
        $this->assertArrayHasKey('methods', $result);
        $this->assertArrayHasKey('dependencies', $result);

        $this->assertIsArray($result['methods']);
        $this->assertIsArray($result['dependencies']);
    }
}
