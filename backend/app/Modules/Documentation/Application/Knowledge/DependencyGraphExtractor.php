<?php

declare(strict_types=1);

namespace App\Modules\Documentation\Application\Knowledge;

use App\Modules\Documentation\Application\Scanner\ProjectScanner;

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
