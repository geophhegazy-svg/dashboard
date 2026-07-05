<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Writer\DocumentationWriter;
use Tests\TestCase;

class DocumentationWriterTest extends TestCase
{
    public function test_write_and_read_documentation(): void
    {
        $directory = storage_path('framework/testing/documentation');

        $writer = new DocumentationWriter($directory);

        $writer->write('models.md', '# Models');

        $this->assertTrue(
            $writer->exists('models.md')
        );

        $this->assertEquals(
            '# Models',
            $writer->read('models.md')
        );

        $writer->delete('models.md');

        $this->assertFalse(
            $writer->exists('models.md')
        );
    }
}
