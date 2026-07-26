<?php

declare(strict_types=1);

namespace App\Core\Kernel\Monitoring;

final readonly class KernelBootMetric
{
    public function __construct(
        private KernelBootStage $stage,
        private float $duration,
    ) {}


    public function stage(): KernelBootStage
    {
        return $this->stage;
    }


    public function duration(): float
    {
        return $this->duration;
    }
}
