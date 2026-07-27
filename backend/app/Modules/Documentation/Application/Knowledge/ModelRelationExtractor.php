<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Knowledge;

use App\Modules\Documentation\Application\Scanner\ProjectScanner;

class ModelRelationExtractor
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function extract(): array
    {
        $models = $this->scanner->models();

        return collect($models)
            ->map(function (array $model): array {

                return [

                    'model' => $model['name'],

                    'class' => $model['class'],

                    'relations' => $model['relations'] ?? [],

                ];
            })
            ->values()
            ->toArray();
    }
}
