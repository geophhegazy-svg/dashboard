<?php

declare(strict_types=1);

namespace App\Services\Documentation\Sections;

class ModelsSection
{
    public function generate(): string
    {
        $models = collect(glob(app_path('Models/*.php')))
            ->map(fn($file) => pathinfo($file, PATHINFO_FILENAME))
            ->sort()
            ->values();

        $markdown = [];
        $markdown[] = '## Models';
        $markdown[] = '';
        $markdown[] = 'Count: ' . $models->count();
        $markdown[] = '';

        foreach ($models as $model) {
            $markdown[] = '- ' . $model;
        }

        return implode(PHP_EOL, $markdown);
    }
}
