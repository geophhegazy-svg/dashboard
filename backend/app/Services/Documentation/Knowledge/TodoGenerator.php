<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class TodoGenerator implements KnowledgeExtractorInterface
{
    public function extract(): array
    {
        $todos = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(base_path('app'))
        );

        foreach ($iterator as $file) {

            if (! $file->isFile() || $file->getExtension() !== 'php') {
                continue;
            }

            $lines = file($file->getPathname());

            foreach ($lines as $number => $line) {

                if (preg_match('/TODO|FIXME|XXX/i', $line)) {

                    $todos[] = [
                        'file' => str_replace(
                            base_path() . DIRECTORY_SEPARATOR,
                            '',
                            $file->getPathname()
                        ),
                        'line' => $number + 1,
                        'text' => trim($line),
                    ];
                }
            }
        }

        return $todos;
    }
}
