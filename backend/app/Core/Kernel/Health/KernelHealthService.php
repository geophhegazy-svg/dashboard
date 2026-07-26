<?php

declare(strict_types=1);

namespace App\Core\Kernel\Health;

use App\Core\Kernel\Health\Contracts\KernelHealthCheckInterface;

final readonly class KernelHealthService
{
    /**
     * @param list<KernelHealthCheckInterface> $checks
     */
    public function __construct(
        private array $checks,
    ) {}


    public function check(): KernelHealthReport
    {
        $results = [];

        foreach ($this->checks as $check) {

            $results[] = $check->check();
        }

        return new KernelHealthReport(
            $results,
        );
    }
}
