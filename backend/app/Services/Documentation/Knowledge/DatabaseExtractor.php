<?php

declare(strict_types=1);

namespace App\Services\Documentation\Knowledge;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseExtractor
{
    public function extract(): array
    {
        $tables = [];

        foreach (Schema::getTables() as $table) {

            $name = is_array($table)
                ? ($table['name'] ?? array_values($table)[0])
                : $table;

            $columns = [];

            foreach (Schema::getColumns($name) as $column) {

                $columns[] = [
                    'name' => $column['name'] ?? '',
                    'type' => $column['type_name'] ?? ($column['type'] ?? ''),
                    'nullable' => $column['nullable'] ?? false,
                    'default' => $column['default'] ?? null,
                ];
            }

            $tables[] = [
                'table' => $name,
                'columns' => $columns,
                'count' => DB::table($name)->count(),
            ];
        }

        usort(
            $tables,
            fn($a, $b) => strcmp($a['table'], $b['table'])
        );

        return $tables;
    }
}
