<?php

declare(strict_types=1);

namespace App\Services\Documentation\Filesystem;

class DocumentationDirectoryManager
{
    public function generatedPath(): string
    {
        return base_path('docs/generated');
    }

    public function ensureExists(): void
    {
        $path = $this->generatedPath();

        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }

    public function file(string $filename): string
    {
        return $this->generatedPath() . DIRECTORY_SEPARATOR . $filename;
    }
}
