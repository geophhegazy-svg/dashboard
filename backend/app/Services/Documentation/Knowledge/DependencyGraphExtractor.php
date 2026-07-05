<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class DependencyGraphExtractor
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function extract(): array
    {
        return [

            'controllers' => $this->scanner->controllers(),

            'services' => $this->scanner->services(),

            'models' => $this->scanner->models(),

        ];
    }
}
