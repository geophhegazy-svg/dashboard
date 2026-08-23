<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Kernel\Lifecycle;

use App\Core\Kernel\Lifecycle\KernelLifecycleManager;
use App\Core\Kernel\Lifecycle\KernelLifecycleState;
use PHPUnit\Framework\TestCase;
use RuntimeException;

final class KernelLifecycleManagerTest extends TestCase
{
    public function test_it_starts_in_created_state(): void
    {
        $manager = new KernelLifecycleManager();

        self::assertSame(
            KernelLifecycleState::Created,
            $manager->state(),
        );
    }

    public function test_it_allows_the_valid_starting_transition(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        self::assertSame(
            KernelLifecycleState::Starting,
            $manager->state(),
        );
    }

    public function test_it_allows_valid_boot_transition(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        self::assertSame(
            KernelLifecycleState::Booting,
            $manager->state(),
        );
    }

    public function test_it_allows_successful_boot_transition(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        self::assertSame(
            KernelLifecycleState::Ready,
            $manager->state(),
        );
    }

    public function test_it_allows_failure_from_starting(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Failed,
        );

        self::assertSame(
            KernelLifecycleState::Failed,
            $manager->state(),
        );
    }

    public function test_it_allows_failure_from_booting(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $manager->transition(
            KernelLifecycleState::Failed,
        );

        self::assertSame(
            KernelLifecycleState::Failed,
            $manager->state(),
        );
    }

    public function test_it_allows_shutdown_from_ready(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        $manager->transition(
            KernelLifecycleState::Stopping,
        );

        $manager->transition(
            KernelLifecycleState::Stopped,
        );

        self::assertSame(
            KernelLifecycleState::Stopped,
            $manager->state(),
        );
    }

    public function test_failed_state_can_transition_to_stopped(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Failed,
        );

        $manager->transition(
            KernelLifecycleState::Stopped,
        );

        self::assertSame(
            KernelLifecycleState::Stopped,
            $manager->state(),
        );
    }

    public function test_it_rejects_created_to_booting(): void
    {
        $manager = new KernelLifecycleManager();

        $this->expectException(RuntimeException::class);

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        self::assertSame(
            KernelLifecycleState::Created,
            $manager->state(),
        );
    }

    public function test_it_rejects_created_to_ready(): void
    {
        $manager = new KernelLifecycleManager();

        $this->expectException(RuntimeException::class);

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        self::assertSame(
            KernelLifecycleState::Created,
            $manager->state(),
        );
    }

    public function test_it_rejects_starting_to_ready(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $this->expectException(RuntimeException::class);

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        self::assertSame(
            KernelLifecycleState::Starting,
            $manager->state(),
        );
    }

    public function test_it_rejects_booting_to_starting(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $this->expectException(RuntimeException::class);

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        self::assertSame(
            KernelLifecycleState::Booting,
            $manager->state(),
        );
    }

    public function test_it_rejects_ready_to_booting(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        $this->expectException(RuntimeException::class);

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        self::assertSame(
            KernelLifecycleState::Ready,
            $manager->state(),
        );
    }

    public function test_it_rejects_stopping_to_ready(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        $manager->transition(
            KernelLifecycleState::Stopping,
        );

        $this->expectException(RuntimeException::class);

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        self::assertSame(
            KernelLifecycleState::Stopping,
            $manager->state(),
        );
    }

    public function test_it_rejects_all_transitions_from_stopped(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        $manager->transition(
            KernelLifecycleState::Stopping,
        );

        $manager->transition(
            KernelLifecycleState::Stopped,
        );

        $this->expectException(RuntimeException::class);

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        self::assertSame(
            KernelLifecycleState::Stopped,
            $manager->state(),
        );
    }

    public function test_rejected_transition_preserves_created_state(): void
    {
        $manager = new KernelLifecycleManager();

        try {
            $manager->transition(
                KernelLifecycleState::Booting,
            );

            self::fail(
                'Expected invalid transition exception was not thrown.',
            );
        } catch (RuntimeException $exception) {
            self::assertSame(
                'Invalid kernel lifecycle transition: created -> booting',
                $exception->getMessage(),
            );
        }

        self::assertSame(
            KernelLifecycleState::Created,
            $manager->state(),
        );
    }

    public function test_rejected_transition_preserves_starting_state(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        try {
            $manager->transition(
                KernelLifecycleState::Ready,
            );

            self::fail(
                'Expected invalid transition exception was not thrown.',
            );
        } catch (RuntimeException $exception) {
            self::assertSame(
                'Invalid kernel lifecycle transition: starting -> ready',
                $exception->getMessage(),
            );
        }

        self::assertSame(
            KernelLifecycleState::Starting,
            $manager->state(),
        );
    }

    public function test_rejected_transition_preserves_booting_state(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        try {
            $manager->transition(
                KernelLifecycleState::Starting,
            );

            self::fail(
                'Expected invalid transition exception was not thrown.',
            );
        } catch (RuntimeException $exception) {
            self::assertSame(
                'Invalid kernel lifecycle transition: booting -> starting',
                $exception->getMessage(),
            );
        }

        self::assertSame(
            KernelLifecycleState::Booting,
            $manager->state(),
        );
    }

    public function test_rejected_transition_preserves_ready_state(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        try {
            $manager->transition(
                KernelLifecycleState::Booting,
            );

            self::fail(
                'Expected invalid transition exception was not thrown.',
            );
        } catch (RuntimeException $exception) {
            self::assertSame(
                'Invalid kernel lifecycle transition: ready -> booting',
                $exception->getMessage(),
            );
        }

        self::assertSame(
            KernelLifecycleState::Ready,
            $manager->state(),
        );
    }

    public function test_rejected_transition_preserves_stopping_state(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        $manager->transition(
            KernelLifecycleState::Stopping,
        );

        try {
            $manager->transition(
                KernelLifecycleState::Ready,
            );

            self::fail(
                'Expected invalid transition exception was not thrown.',
            );
        } catch (RuntimeException $exception) {
            self::assertSame(
                'Invalid kernel lifecycle transition: stopping -> ready',
                $exception->getMessage(),
            );
        }

        self::assertSame(
            KernelLifecycleState::Stopping,
            $manager->state(),
        );
    }

    public function test_rejected_transition_preserves_stopped_state(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        $manager->transition(
            KernelLifecycleState::Stopping,
        );

        $manager->transition(
            KernelLifecycleState::Stopped,
        );

        try {
            $manager->transition(
                KernelLifecycleState::Starting,
            );

            self::fail(
                'Expected invalid transition exception was not thrown.',
            );
        } catch (RuntimeException $exception) {
            self::assertSame(
                'Invalid kernel lifecycle transition: stopped -> starting',
                $exception->getMessage(),
            );
        }

        self::assertSame(
            KernelLifecycleState::Stopped,
            $manager->state(),
        );
    }

    public function test_reset_returns_manager_to_created_state(): void
    {
        $manager = new KernelLifecycleManager();

        $manager->transition(
            KernelLifecycleState::Starting,
        );

        $manager->transition(
            KernelLifecycleState::Booting,
        );

        $manager->transition(
            KernelLifecycleState::Ready,
        );

        $manager->reset();

        self::assertSame(
            KernelLifecycleState::Created,
            $manager->state(),
        );
    }
}
