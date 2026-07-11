<?php

declare(strict_types=1);

namespace App\Services\Network\Providers\MikroTik;

use RouterOS\Query;

class MikroTikMonitoringService
{
    public function __construct(
        protected MikroTikQueryService $query
    ) {
    }


    /**
     * Get router system resources.
     *
     * @return array<string,mixed>
     */
    public function getSystemResource(): array
    {
        $resource = $this->query->first(
            new Query('/system/resource/print')
        );


        if ($resource === null) {
            return [];
        }


        return [
            'uptime' =>
                $resource['uptime'] ?? null,

            'version' =>
                $resource['version'] ?? null,

            'board_name' =>
                $resource['board-name'] ?? null,

            'architecture' =>
                $resource['architecture-name'] ?? null,

            'cpu_load' =>
                (int) (
                    $resource['cpu-load']
                    ?? 0
                ),

            'cpu_count' =>
                (int) (
                    $resource['cpu-count']
                    ?? 1
                ),

            'memory_total' =>
                (int) (
                    $resource['total-memory']
                    ?? 0
                ),

            'memory_free' =>
                (int) (
                    $resource['free-memory']
                    ?? 0
                ),

            'memory_used' =>
                $this->calculateMemoryUsage(
                    $resource
                ),
        ];
    }



    /**
     * Get router identity.
     *
     * @return array<string,mixed>
     */
    public function getIdentity(): array
    {
        return $this->query->first(
            new Query('/system/identity/print')
        ) ?? [];
    }



    /**
     * Get interfaces.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getInterfaces(): array
    {
        return $this->query->execute(
            new Query('/interface/print')
        );
    }



    /**
     * Get interface traffic counters.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getInterfaceTraffic(): array
    {
        return $this->query->execute(
            new Query('/interface/print')
        );
    }

    /**
     * Calculate memory usage percentage.
     *
     * @param array<string,mixed> $resource
     */
    protected function calculateMemoryUsage(
        array $resource
    ): float {

        $total = (int) (
            $resource['total-memory']
            ?? 0
        );


        $free = (int) (
            $resource['free-memory']
            ?? 0
        );


        if ($total <= 0) {
            return 0;
        }


        $used = $total - $free;


        return round(
            ($used / $total) * 100,
            2
        );
    }



    /**
     * Ping check.
     */
    public function ping(
        string $address,
        int $count = 3
    ): bool {

        try {

            $query = (new Query('/ping'))
                ->equal('address', $address)
                ->equal('count', $count);


            $result = $this->query->execute($query);


            return count($result) > 0;
        } catch (\Throwable) {

            return false;
        }
    }



    /**
     * Full router health check.
     *
     * @return array<string,mixed>
     */
    public function healthCheck(): array
    {
        $resource = $this->getSystemResource();

        $identity = $this->getIdentity();


        return [
            'online' => !empty($resource),

            'identity' =>
            $identity['name'] ?? null,

            'cpu' =>
            $resource['cpu_load'] ?? null,

            'memory' =>
            $resource['memory_used'] ?? null,

            'uptime' =>
            $resource['uptime'] ?? null,

            'version' =>
            $resource['version'] ?? null,

            'checked_at' =>
            now()->toDateTimeString(),
        ];
    }



    /**
     * Monitoring summary.
     *
     * @return array<string,mixed>
     */
    public function summary(): array
    {
        return [
            'system' =>
            $this->getSystemResource(),

            'identity' =>
            $this->getIdentity(),

            'interfaces_count' =>
            count(
                $this->getInterfaces()
            ),

            'health' =>
            $this->healthCheck(),
        ];
    }
}
