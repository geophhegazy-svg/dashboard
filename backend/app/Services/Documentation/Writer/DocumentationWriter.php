<?php

declare(strict_types=1);

namespace App\Services\Documentation\Writer;

use Illuminate\Support\Facades\File;

class DocumentationWriter
{
    protected string $basePath;

    public function __construct(?string $basePath = null)
    {
        $this->basePath = $basePath ?? base_path('docs/generated');
    }

    public function write(string $filename, string $contents): void
    {
        $path = $this->basePath . '/' . $filename;

        File::ensureDirectoryExists(dirname($path));

        File::put($path, $contents);
    }

    public function exists(string $filename): bool
    {
        return File::exists($this->basePath . '/' . $filename);
    }

    public function read(string $filename): string
    {
        return File::get($this->basePath . '/' . $filename);
    }

    public function delete(string $filename): void
    {
        File::delete($this->basePath . '/' . $filename);
    }
}
