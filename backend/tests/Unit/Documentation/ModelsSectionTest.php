<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Sections\ModelsSection;
use Tests\TestCase;

class ModelsSectionTest extends TestCase
{
    public function test_generates_models_section(): void
    {
        $section = new ModelsSection();

        $markdown = $section->generate();

        $this->assertStringContainsString('## Models', $markdown);
        $this->assertStringContainsString('Customer', $markdown);
        $this->assertStringContainsString('Subscription', $markdown);
        $this->assertStringContainsString('Invoice', $markdown);
    }
}
