<?php

declare(strict_types=1);

namespace App\Core\Kernel\Health;

final readonly class KernelHealthReport
{
    /**
     * @param list<KernelHealthResult> $results
     */
    public function __construct(
        private array $results,
    ) {}


    /**
     * @return list<KernelHealthResult>
     */
    public function results(): array
    {
        return $this->results;
    }


    public function healthy(): bool
    {
        foreach ($this->results as $result) {

            if (! $result->passed()) {
                return false;
            }
        }

        return true;
    }


    public function status(): string
    {
        return $this->healthy()
            ? 'HEALTHY'
            : 'FAILED';
    }
}
