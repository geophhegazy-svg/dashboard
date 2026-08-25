<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Health\Checks;

use App\Core\Kernel\Health\Checks\KernelLifecycleCheck;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;
use Tests\TestCase;

final class KernelLifecycleCheckTest extends TestCase
{
    public function test_check_passes_when_kernel_lifecycle_is_ready(): void
    {
        $lifecycle = new KernelLifecycleManager();

        $lifecycle->transition(
            KernelLifecycleState::Starting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Booting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Ready,
        );

        $result = (new KernelLifecycleCheck(
            $lifecycle,
        ))->check();

        self::assertSame(
            'Kernel Lifecycle',
            $result->name(),
        );

        self::assertTrue(
            $result->passed(),
        );

        self::assertSame(
            'Kernel lifecycle is ready.',
            $result->message(),
        );
    }

    public function test_check_fails_when_kernel_lifecycle_is_failed(): void
    {
        $lifecycle = new KernelLifecycleManager();

        $lifecycle->transition(
            KernelLifecycleState::Starting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Booting,
        );

        $lifecycle->transition(
            KernelLifecycleState::Failed,
        );

        $result = (new KernelLifecycleCheck(
            $lifecycle,
        ))->check();

        self::assertFalse(
            $result->passed(),
        );

        self::assertSame(
            'Kernel lifecycle is not ready (state: failed).',
            $result->message(),
        );
    }

    public function test_check_fails_when_kernel_lifecycle_is_created(): void
    {
        $lifecycle = new KernelLifecycleManager();

        $result = (new KernelLifecycleCheck(
            $lifecycle,
        ))->check();

        self::assertFalse(
            $result->passed(),
        );

        self::assertSame(
            'Kernel lifecycle is not ready (state: created).',
            $result->message(),
        );
    }
}
