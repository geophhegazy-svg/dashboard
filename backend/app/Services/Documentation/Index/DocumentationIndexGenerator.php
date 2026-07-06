<?php

declare(strict_types=1);

namespace App\Services\Documentation\Index;

use Illuminate\Support\Facades\File;

class DocumentationIndexGenerator
{
    public function generate(string $directory): string
    {
        if (! File::isDirectory($directory)) {
            return "# Documentation Index\n\nNo documentation found.\n";
        }

        $markdown = [
            '# Documentation Index',
            '',
        ];

        $files = collect(File::allFiles($directory))
            ->sortBy(fn($file) => $file->getFilename());

        foreach ($files as $file) {
            $relative = str_replace($directory . DIRECTORY_SEPARATOR, '', $file->getPathname());

            $markdown[] = '- [' . $relative . '](' . str_replace('\\', '/', $relative) . ')';
        }

        $markdown[] = '';

        return implode(PHP_EOL, $markdown);
    }
}
