<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class ModuleExtractor
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function extract(): array
    {
        $project = $this->scanner->all();

        return [

            [
                'name' => 'Models',
                'count' => count($project['models']),
                'classes' => array_column($project['models'], 'name'),
            ],

            [
                'name' => 'Services',
                'count' => count($project['services']),
                'classes' => array_column($project['services'], 'name'),
            ],

            [
                'name' => 'Controllers',
                'count' => count($project['controllers']),
                'classes' => array_column($project['controllers'], 'name'),
            ],

            [
                'name' => 'Repositories',
                'count' => count($project['repositories']),
                'classes' => array_column($project['repositories'], 'name'),
            ],

            [
                'name' => 'Actions',
                'count' => count($project['actions']),
                'classes' => array_column($project['actions'], 'name'),
            ],

        ];
    }
}
