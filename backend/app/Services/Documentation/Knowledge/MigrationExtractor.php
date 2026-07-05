<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

class MigrationExtractor
{
    public function extract(): array
    {
        $migrations = glob(database_path('migrations/*.php'));

        sort($migrations);

        return collect($migrations)
            ->map(function (string $file): array {

                return [

                    'name' => basename($file),

                    'path' => $file,

                ];
            })
            ->values()
            ->toArray();
    }
}
