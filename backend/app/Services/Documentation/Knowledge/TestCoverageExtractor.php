<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class TestCoverageExtractor implements KnowledgeExtractorInterface
{
    public function extract(): array
    {
        $tests = [];

        foreach (glob(base_path('tests/**/*.php')) ?: [] as $file) {

            $tests[] = [

                'name' => basename($file, '.php'),

                'path' => str_replace(base_path() . DIRECTORY_SEPARATOR, '', $file),

            ];
        }

        // دعم الأنظمة التي لا يعمل عليها glob(**)
        if (empty($tests)) {

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(base_path('tests'))
            );

            foreach ($iterator as $file) {

                if (! $file->isFile()) {
                    continue;
                }

                if ($file->getExtension() !== 'php') {
                    continue;
                }

                $tests[] = [

                    'name' => $file->getBasename('.php'),

                    'path' => str_replace(
                        base_path() . DIRECTORY_SEPARATOR,
                        '',
                        $file->getPathname()
                    ),

                ];
            }
        }

        usort(
            $tests,
            fn($a, $b) => strcmp($a['path'], $b['path'])
        );

        return $tests;
    }
}
