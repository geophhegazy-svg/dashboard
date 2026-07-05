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
            new RecursiveDirectoryIterator(app_path('Services'))
        );

        foreach ($iterator as $file) {

            if (!$file->isFile()) {
                continue;
            }

            if ($file->getExtension() !== 'php') {
                continue;
            }

            $services[] = $file->getBasename('.php');
        }

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
