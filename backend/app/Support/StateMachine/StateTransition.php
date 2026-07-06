<?php

declare(strict_types=1);

namespace App\Support\StateMachine;

interface StateTransition
{
    public function canTransition(
        string $from,
        string $to
    ): bool;
}
