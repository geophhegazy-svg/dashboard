<?php

declare(strict_types=1);

namespace App\Core\Kernel\Registration\Planner;

final readonly class RegistrationPlan
{
    /**
     * @param list<RegistrationStep> $steps
     */
    public function __construct(
        private array $steps,
    ) {}

    /**
     * @return list<RegistrationStep>
     */
    public function steps(): array
    {
        return $this->steps;
    }

    public function count(): int
    {
        return count($this->steps);
    }

    public function isEmpty(): bool
    {
        return $this->steps === [];
    }
}
