<?php

declare(strict_types=1);

namespace App\Core\Kernel\Monitoring;

/**
 * @internal
 */
final readonly class KernelMonitoringService
{
    public function __construct(
        private KernelBootTimeline $timeline,
    ) {}


    public function report(): KernelBootReport
    {
        return new KernelBootReport(
            metrics: $this->timeline->metrics(),
            total: $this->timeline->total(),
        );
    }
}
