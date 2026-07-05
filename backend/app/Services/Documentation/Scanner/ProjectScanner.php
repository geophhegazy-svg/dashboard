<?php

declare(strict_types=1);

namespace App\Services\Documentation\Scanner;

class ProjectScanner
{
    public function __construct(
        private readonly FileScanner $files = new FileScanner(),
        private readonly ClassFinder $finder = new ClassFinder(),
        private readonly MetadataExtractor $extractor = new MetadataExtractor(),
    ) {}

    public function models(): array
    {
        return $this->scanDirectory(app_path('Models'));
    }

    public function services(): array
    {
        return $this->scanDirectory(app_path('Services'));
    }

    public function controllers(): array
    {
        return $this->scanDirectory(app_path('Http/Controllers'));
    }

    public function repositories(): array
    {
        return $this->scanDirectory(app_path('Repositories'));
    }

    public function actions(): array
    {
        return $this->scanDirectory(app_path('Actions'));
    }

    public function all(): array
    {
        return [
            'models' => $this->models(),
            'services' => $this->services(),
            'controllers' => $this->controllers(),
            'repositories' => $this->repositories(),
            'actions' => $this->actions(),
        ];
    }

    private function scanDirectory(string $directory): array
    {
        $files = $this->files->scan($directory);

        $classes = $this->finder->findMany($files);

        $metadata = [];

        foreach ($classes as $class) {

            if (! class_exists($class)) {
                continue;
            }

            $metadata[] = $this->extractor->extract($class);
        }

        usort(
            $metadata,
            fn($a, $b) => strcmp($a['name'], $b['name'])
        );

        return $metadata;
    }
}
