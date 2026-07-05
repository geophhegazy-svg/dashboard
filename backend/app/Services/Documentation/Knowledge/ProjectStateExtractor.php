<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class ProjectStateExtractor
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function extract(): array
    {
        $project = $this->scanner->all();

        return [

            'models' => count($project['models']),

            'services' => count($project['services']),

            'controllers' => count($project['controllers']),

            'repositories' => count($project['repositories']),

            'actions' => count($project['actions']),

            'generated_at' => now()->toDateTimeString(),

        ];
    }
}
