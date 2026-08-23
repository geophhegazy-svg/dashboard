<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Health\Checks;

use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Core\Kernel\Health\Checks\ManifestAvailabilityCheck;
use PHPUnit\Framework\TestCase;

final class ManifestAvailabilityCheckTest extends TestCase
{
    public function test_check_fails_when_manifest_is_missing(): void
    {
        $cache = $this->createMock(
            ModuleManifestCacheInterface::class,
        );

        $cache
            ->expects(self::once())
            ->method('load')
            ->willReturn(null);

        $check = new ManifestAvailabilityCheck($cache);

        $result = $check->check();

        self::assertSame(
            'Manifest',
            $result->name(),
        );

        self::assertFalse(
            $result->passed(),
        );

        self::assertSame(
            'Compiled manifest is missing.',
            $result->message(),
        );
    }


    public function test_check_passes_when_manifest_is_available(): void
    {
        $cache = $this->createMock(
            ModuleManifestCacheInterface::class,
        );

        $manifest = new CompiledModuleManifest([
            new \App\Core\Kernel\Compiler\CompiledModule(
                class: 'Tests\\Fixtures\\Kernel\\ModuleOne',
                name: 'module-one',
                dependencies: [],
                resources: [],
            ),
            new \App\Core\Kernel\Compiler\CompiledModule(
                class: 'Tests\\Fixtures\\Kernel\\ModuleTwo',
                name: 'module-two',
                dependencies: [],
                resources: [],
            ),
            new \App\Core\Kernel\Compiler\CompiledModule(
                class: 'Tests\\Fixtures\\Kernel\\ModuleThree',
                name: 'module-three',
                dependencies: [],
                resources: [],
            ),
        ]);

        $cache
            ->expects(self::once())
            ->method('load')
            ->willReturn($manifest);

        $check = new ManifestAvailabilityCheck($cache);

        $result = $check->check();

        self::assertSame(
            'Manifest',
            $result->name(),
        );

        self::assertTrue(
            $result->passed(),
        );

        self::assertSame(
            'Manifest loaded (3 modules).',
            $result->message(),
        );
    }
}
