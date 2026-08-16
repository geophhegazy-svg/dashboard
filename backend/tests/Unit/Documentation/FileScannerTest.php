<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Modules\Documentation\Application\Scanner\FileScanner;
use Tests\TestCase;

class FileScannerTest extends TestCase
{
    public function test_scan_models_directory(): void
    {
        $scanner = new FileScanner();

        $files = $scanner->scan(
            app_path('Modules/Customer/Infrastructure/Persistence/Models')
        );

        $this->assertNotEmpty($files);

        $this->assertContains(
            app_path('Modules/Customer/Infrastructure/Persistence/Models/Customer.php'),
            $files
        );
    }
}
