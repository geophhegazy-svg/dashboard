<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Scanner\FileScanner;
use Tests\TestCase;

class FileScannerTest extends TestCase
{
    public function test_scan_models_directory(): void
    {
        $scanner = new FileScanner();

        $files = $scanner->scan(
            app_path('Models')
        );

        $this->assertNotEmpty($files);

        $this->assertContains(
            app_path('Models/Customer.php'),
            $files
        );
    }
}
