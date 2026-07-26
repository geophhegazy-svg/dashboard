<?php

declare(strict_types=1);

namespace App\Core\Kernel\Monitoring;

final readonly class KernelBootReport
{
    /**
     * @param list<KernelBootMetric> $metrics
     */
    public function __construct(
        private array $metrics,
        private float $total,
    ) {}


    /**
     * @return list<KernelBootMetric>
     */
    public function metrics(): array
    {
        return $this->metrics;
    }


    public function total(): float
    {
        return $this->total;
    }


    public function totalMilliseconds(): float
    {
        return $this->total * 1000;
    }
}
