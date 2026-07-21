<?php

declare(strict_types=1);

namespace App\Services\Documentation\Sections;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ServicesSection
{
    public function generate(): string
    {
        $services = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(app_path())
        );

        foreach ($iterator as $file) {

            if (! $file->isFile()) {
                continue;
            }

            if ($file->getExtension() !== 'php') {
                continue;
            }

            $path = $file->getPathname();

            if (
                str_contains($path, DIRECTORY_SEPARATOR . 'Documentation' . DIRECTORY_SEPARATOR)
                || str_contains($path, DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR)
            ) {
                continue;
            }

            $name = $file->getBasename('.php');

            if (
                ! str_ends_with($name, 'Service')
                && ! str_ends_with($name, 'Manager')
            ) {
                continue;
            }

            $services[] = $name;
        }

        $services = array_values(array_unique($services));

        sort($services);

        $markdown = [];

        $markdown[] = '# Services';
        $markdown[] = '';
        $markdown[] = 'Count: ' . count($services);
        $markdown[] = '';

        foreach ($services as $service) {
            $markdown[] = "- {$service}";
        }

        return implode(PHP_EOL, $markdown);
    }
}
