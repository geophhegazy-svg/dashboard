<?php

declare(strict_types=1);

namespace App\Reports\Registry;

use App\Reports\Contracts\ReportInterface;
use InvalidArgumentException;

class ReportRegistry
{
    /**
     * @var array<string, ReportInterface>
     */
    private array $reports = [];

    /**
     * Register report.
     */
    public function register(
        ReportInterface $report
    ): self {

        $this->reports[$report->name()] = $report;

        return $this;
    }

    /**
     * Get report by name.
     */
    public function get(
        string $name
    ): ReportInterface {

        if (! isset($this->reports[$name])) {
            throw new InvalidArgumentException(
                "Report [{$name}] is not registered."
            );
        }

        return $this->reports[$name];
    }

    /**
     * Check if report exists.
     */
    public function has(
        string $name
    ): bool {

        return isset($this->reports[$name]);
    }

    /**
     * Return all registered reports.
     *
     * @return array<string, ReportInterface>
     */
    public function all(): array
    {
        return $this->reports;
    }

    /**
     * Return reports metadata.
     */
    public function list(): array
    {
        return array_values(
            array_map(
                static fn(ReportInterface $report): array => [
                    'name' => $report->name(),
                    'title' => $report->title(),
                ],
                $this->reports
            )
        );
    }

    /**
     * Number of registered reports.
     */
    public function count(): int
    {
        return count($this->reports);
    }
}
