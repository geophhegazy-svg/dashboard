<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Health\Checks;

use App\Core\Kernel\Health\Checks\KernelBootCheck;
use App\Core\Kernel\Runtime\KernelRuntimeContext;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use App\Core\Kernel\Compiler\CompiledModuleManifest;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class KernelBootCheckTest extends TestCase
{
    public function test_check_fails_when_runtime_is_not_booted(): void
    {
        $runtime = new KernelRuntimeState();

        $result = (new KernelBootCheck($runtime))->check();

        self::assertFalse($result->passed());
        self::assertSame('Kernel Boot', $result->name());
        self::assertSame(
            'Kernel runtime context is missing.',
            $result->message(),
        );
    }

    public function test_check_passes_when_runtime_is_booted(): void
    {
        $runtime = new KernelRuntimeState();

        $runtime->set(
            new KernelRuntimeContext(
                new CompiledModuleManifest([]),
                new DateTimeImmutable(),
            ),
        );

        $result = (new KernelBootCheck($runtime))->check();

        self::assertTrue($result->passed());
        self::assertSame('Kernel Boot', $result->name());
        self::assertSame(
            'Kernel is booted successfully.',
            $result->message(),
        );
    }
}
