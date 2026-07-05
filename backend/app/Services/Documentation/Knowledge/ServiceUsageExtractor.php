<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use App\Services\Documentation\Scanner\ProjectScanner;

class ServiceUsageExtractor
{
    public function __construct(
        protected ProjectScanner $scanner = new ProjectScanner()
    ) {}

    public function extract(): array
    {
        $services = $this->scanner->services();

        return collect($services)
            ->map(function (array $service): array {

                return [

                    'service' => $service['name'],

                    'class' => $service['class'],

                    'methods' => $service['methods'] ?? [],

                ];
            })
            ->values()
            ->toArray();
    }
}
