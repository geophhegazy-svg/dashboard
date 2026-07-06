<?php

declare(strict_types=1);

namespace App\Services\Documentation\Filesystem;

use Illuminate\Support\Facades\File;

class DocumentationDirectoryManager
{
    public function generatedPath(): string
    {
        return base_path('docs/generated');
    }

    public function ensureExists(): void
    {
        File::ensureDirectoryExists(
            $this->generatedPath()
        );
    }

    public function file(string $filename): string
    {
        return $this->generatedPath()
            . DIRECTORY_SEPARATOR
            . $filename;
    }
}
