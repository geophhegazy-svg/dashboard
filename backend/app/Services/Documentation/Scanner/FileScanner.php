<?php

declare(strict_types=1);

namespace App\Services\Documentation\Scanner;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileScanner
{
    public function scan(string $directory): array
    {
        if (! is_dir($directory)) {
            return [];
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory)
        );

        $files = [];

        foreach ($iterator as $file) {

            if (! $file->isFile()) {
                continue;
            }

            if ($file->getExtension() !== 'php') {
                continue;
            }

            $files[] = $file->getRealPath();
        }

        sort($files);

        return $files;
    }
}
