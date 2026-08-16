<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Sections;

use App\Modules\Documentation\Application\Scanner\ProjectScanner;

class ModelsSection
{
    public function __construct(
        private readonly ProjectScanner $scanner = new ProjectScanner(),
    ) {}

    public function generate(): string
    {
        $models = collect($this->scanner->models())
            ->pluck('name')
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
