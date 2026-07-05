<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Scanner\MetadataExtractor;
use Tests\TestCase;

class MetadataExtractorTest extends TestCase
{
    public function test_extract_returns_metadata(): void
    {
        $extractor = new MetadataExtractor();

        $metadata = $extractor->extract(
            \App\Models\Customer::class
        );

        $this->assertIsArray($metadata);

        $this->assertEquals(
            'Customer',
            $metadata['name']
        );

        $this->assertEquals(
            \App\Models\Customer::class,
            $metadata['class']
        );
    }
}
