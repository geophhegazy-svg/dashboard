<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use PHPUnit\Framework\TestCase;
use App\Services\Documentation\Builder\MarkdownBuilder;

class MarkdownBuilderTest extends TestCase
{
    public function test_builder_generates_markdown(): void
    {
        $builder = new MarkdownBuilder();

        $markdown = $builder
            ->title('EgyptNet')
            ->h2('Models')
            ->bullet('Customer')
            ->bullet('Subscription')
            ->separator()
            ->render();

        $this->assertStringContainsString('# EgyptNet', $markdown);
        $this->assertStringContainsString('## Models', $markdown);
        $this->assertStringContainsString('- Customer', $markdown);
        $this->assertStringContainsString('- Subscription', $markdown);
    }
}
