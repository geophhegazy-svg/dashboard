<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Knowledge\HandoverDocumentGenerator;
use Tests\TestCase;

class HandoverDocumentGeneratorTest extends TestCase
{
    public function test_generates_handover(): void
    {
        $generator = new HandoverDocumentGenerator();

        $markdown = $generator->generate();

        $this->assertStringContainsString(
            'PROJECT HANDOVER DOCUMENT',
            $markdown
        );
    }
}
