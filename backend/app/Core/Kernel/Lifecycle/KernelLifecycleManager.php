<?php

declare(strict_types=1);

namespace App\Core\Kernel\Lifecycle;

use RuntimeException;

final class KernelLifecycleManager
{
    private KernelLifecycleState $state;


    public function __construct()
    {
        $this->state = KernelLifecycleState::Created;
    }


    public function state(): KernelLifecycleState
    {
        return $this->state;
    }


    public function transition(
        KernelLifecycleState $state,
    ): void {

        if (! $this->canTransition($state)) {

            throw new RuntimeException(
                sprintf(
                    'Invalid kernel lifecycle transition: %s -> %s',
                    $this->state->value,
                    $state->value,
                ),
            );
        }


        $this->state = $state;
    }


    public function reset(): void
    {
        $this->state = KernelLifecycleState::Created;
    }


    private function canTransition(
        KernelLifecycleState $next,
    ): bool {

        return match ($this->state) {

            KernelLifecycleState::Created =>
            $next === KernelLifecycleState::Starting,


            KernelLifecycleState::Starting =>
            in_array(
                $next,
                [
                    KernelLifecycleState::Booting,
                    KernelLifecycleState::Failed,
                ],
                true,
            ),


            KernelLifecycleState::Booting =>
            in_array(
                $next,
                [
                    KernelLifecycleState::Ready,
                    KernelLifecycleState::Failed,
                ],
                true,
            ),


            KernelLifecycleState::Ready =>
            in_array(
                $next,
                [
                    KernelLifecycleState::Stopping,
                    KernelLifecycleState::Failed,
                ],
                true,
            ),


            KernelLifecycleState::Stopping =>
            $next === KernelLifecycleState::Stopped,


            KernelLifecycleState::Failed =>
            $next === KernelLifecycleState::Stopped,


            KernelLifecycleState::Stopped =>
            false,
        };
    }
}
