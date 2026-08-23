<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Runtime;

use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Runtime\KernelRuntimeContext;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class KernelRuntimeStateTest extends TestCase
{
    public function test_runtime_is_not_booted_initially(): void
    {
        $runtime = new KernelRuntimeState();

        self::assertFalse($runtime->isBooted());
    }

    public function test_context_access_before_initialization_fails(): void
    {
        $runtime = new KernelRuntimeState();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            'Kernel runtime context is not initialized.',
        );

        $runtime->context();
    }

    public function test_set_initializes_runtime_context(): void
    {
        $runtime = new KernelRuntimeState();

        $manifest = new CompiledModuleManifest([]);

        $bootedAt = new DateTimeImmutable();

        $context = new KernelRuntimeContext(
            $manifest,
            $bootedAt,
        );

        $runtime->set($context);

        self::assertTrue($runtime->isBooted());
        self::assertSame($context, $runtime->context());
        self::assertSame($manifest, $runtime->manifest());
        self::assertSame($bootedAt, $runtime->bootedAt());
    }

    public function test_reset_clears_runtime_state(): void
    {
        $runtime = new KernelRuntimeState();

        $context = new KernelRuntimeContext(
            new CompiledModuleManifest([]),
            new DateTimeImmutable(),
        );

        $runtime->set($context);

        self::assertTrue($runtime->isBooted());

        $runtime->reset();

        self::assertFalse($runtime->isBooted());

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            'Kernel runtime context is not initialized.',
        );

        $runtime->context();
    }
}
