<?php

declare(strict_types=1);

namespace Tests\Unit\Architecture;

use PHPUnit\Framework\TestCase;

final class CrossModuleAggregateMutationBoundaryTest extends TestCase
{
    public function test_modules_do_not_directly_mutate_cross_module_infrastructure_models(): void
    {
        $root = dirname(__DIR__, 3) . '/app/Modules';

        $violations = [];

        foreach (glob($root . '/*/Application/**/*.php') ?: [] as $file) {
            $ownerModule = $this->moduleFromPath($file);

            if ($ownerModule === null) {
                continue;
            }

            $contents = file_get_contents($file);

            if ($contents === false) {
                continue;
            }

            preg_match_all(
                '/use\s+App\\\\Modules\\\\([A-Za-z0-9_]+)\\\\Infrastructure\\\\Persistence\\\\Models\\\\([A-Za-z0-9_]+);/',
                $contents,
                $matches,
                PREG_SET_ORDER,
            );

            foreach ($matches as $match) {
                $targetModule = $match[1];
                $model = $match[2];

                if ($targetModule === $ownerModule) {
                    continue;
                }

                $mutationPattern = sprintf(
                    '/\b(?:%s)::(?:create|update|delete|forceDelete|destroy|upsert)\s*\(|\bnew\s+%s\s*\(/',
                    preg_quote($model, '/'),
                    preg_quote($model, '/'),
                );

                if (preg_match($mutationPattern, $contents) === 1) {
                    $violations[] = sprintf(
                        '%s → %s\\%s',
                        $this->relativePath($file),
                        $targetModule,
                        $model,
                    );
                }
            }
        }

        $this->assertSame(
            [],
            $violations,
            "Cross-module aggregate mutation detected:\n"
            . implode("\n", $violations),
        );
    }

    private function moduleFromPath(string $file): ?string
    {
        $normalized = str_replace('\\', '/', $file);

        if (
            preg_match(
                '#/app/Modules/([^/]+)/Application/#',
                $normalized,
                $match,
            ) !== 1
        ) {
            return null;
        }

        return $match[1];
    }

    private function relativePath(string $file): string
    {
        $root = dirname(__DIR__, 3);

        return ltrim(
            str_replace($root, '', $file),
            '/',
        );
    }
}
