<?php

declare(strict_types=1);

namespace App\Services\Documentation;

use App\Services\Documentation\Filesystem\DocumentationDirectoryManager;

class MarkdownExporter
{
    public function __construct(
        protected DocumentationDirectoryManager $directories = new DocumentationDirectoryManager()
    ) {}

    public function export(string $filename, string $content): void
    {
        $this->directories->ensureExists();

        file_put_contents(
            $this->directories->file($filename),
            trim($content) . PHP_EOL
        );
    }
}
