<?php

declare(strict_types=1);

namespace App\Core\Kernel\Monitoring;

final class KernelBootTimeline
{
    /**
     * @var list<KernelBootMetric>
     */
    private array $metrics = [];


    private ?float $startedAt = null;


    public function start(): void
    {
        $this->startedAt = microtime(true);
    }


    public function record(
        KernelBootStage $stage,
        float $started,
    ): void {

        $this->metrics[] = new KernelBootMetric(
            $stage,
            microtime(true) - $started,
        );
    }


    /**
     * @return list<KernelBootMetric>
     */
    public function metrics(): array
    {
        return $this->metrics;
    }


    public function total(): float
    {
        if ($this->startedAt === null) {
            return 0;
        }

        return microtime(true) - $this->startedAt;
    }
}
