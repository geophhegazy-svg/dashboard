<?php

declare(strict_types=1);

namespace App\Services\Network\Providers\MikroTik;

use App\Exceptions\Network\ResourceNotFoundException;
use Illuminate\Support\Facades\Log;
use RouterOS\Query;

class MikroTikQueueService
{
    public function __construct(
        protected MikroTikQueryService $query
    ) {
    }


    /**
     * Get all simple queues.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getAll(): array
    {
        return $this->query->execute(
            new Query('/queue/simple/print')
        );
    }



    /**
     * Get queue by name.
     *
     * @return array<string,mixed>|null
     */
    public function find(
        string $name
    ): ?array {

        $query = (new Query('/queue/simple/print'))
            ->where('name', $name);


        return $this->query->first($query);
    }



    /**
     * Create simple queue.
     */
    public function create(
        string $name,
        string $target,
        string $maxLimit,
        ?string $limitAt = null,
        int $priority = 1,
        array $options = []
    ): bool {

        $query = (new Query('/queue/simple/add'))
            ->equal('name', $name)
            ->equal('target', $target)
            ->equal('max-limit', $maxLimit)
            ->equal('priority', $priority);


        if ($limitAt !== null) {

            $query->equal(
                'limit-at',
                $limitAt
            );
        }


        if (isset($options['comment'])) {

            $query->equal(
                'comment',
                $options['comment']
            );
        }


        if (isset($options['queue'])) {

            $query->equal(
                'queue',
                $options['queue']
            );
        }


        return $this->query->write($query);
    }



    /**
     * Update queue.
     *
     * @param array<string,mixed> $data
     */
    public function update(
        string $name,
        array $data
    ): bool {

        $queue = $this->find($name);


        if ($queue === null) {

            throw ResourceNotFoundException::missing(
                'simple-queue',
                [
                    'name' => $name,
                ]
            );
        }


        $query = (new Query('/queue/simple/set'))
            ->equal('.id', $queue['.id']);


        foreach ($data as $key => $value) {

            $query->equal(
                str_replace('_', '-', $key),
                $value
            );
        }


        return $this->query->write($query);
    }

    /**
     * Delete simple queue.
     */
    public function delete(
        string $name
    ): bool {

        $queue = $this->find($name);


        if ($queue === null) {

            throw ResourceNotFoundException::missing(
                'simple-queue',
                [
                    'name' => $name,
                ]
            );
        }


        $query = (new Query('/queue/simple/remove'))
            ->equal('.id', $queue['.id']);


        return $this->query->write($query);
    }



    /**
     * Disable simple queue.
     */
    public function disable(
        string $name
    ): bool {

        return $this->changeState(
            $name,
            true
        );
    }



    /**
     * Enable simple queue.
     */
    public function enable(
        string $name
    ): bool {

        return $this->changeState(
            $name,
            false
        );
    }



    /**
     * Change queue enabled state.
     */
    protected function changeState(
        string $name,
        bool $disabled
    ): bool {

        $queue = $this->find($name);


        if ($queue === null) {

            throw ResourceNotFoundException::missing(
                'simple-queue',
                [
                    'name' => $name,
                ]
            );
        }


        $query = (new Query('/queue/simple/set'))
            ->equal('.id', $queue['.id'])
            ->equal(
                'disabled',
                $disabled ? 'yes' : 'no'
            );


        return $this->query->write($query);
    }



    /**
     * Get queue traffic counters.
     *
     * @return array<int,array<string,mixed>>
     */
    public function getUsage(): array
    {
        $queues = $this->getAll();


        return array_map(
            function (array $queue) {

                return [
                    'id' => $queue['.id'] ?? null,

                    'name' =>
                    $queue['name'] ?? null,

                    'bytes_in' =>
                    (int) ($queue['bytes-in'] ?? 0),

                    'bytes_out' =>
                    (int) ($queue['bytes-out'] ?? 0),

                    'total_bytes' => (
                        (int) ($queue['bytes-in'] ?? 0)
                        +
                        (int) ($queue['bytes-out'] ?? 0)
                    ),

                    'packet_marks' =>
                    $queue['packet-marks'] ?? null,

                    'target' =>
                    $queue['target'] ?? null,
                ];
            },
            $queues
        );
    }

    /**
     * Get queue by PPPoE username.
     *
     * EgyptNet convention:
     * Queue name = PPPoE username
     */
    public function getUserQueue(
        string $username
    ): ?array {

        return $this->find($username);
    }



    /**
     * Update user speed.
     */
    public function updateSpeed(
        string $username,
        string $download,
        string $upload
    ): bool {

        return $this->update(
            $username,
            [
                'max_limit' => "{$upload}/{$download}",
            ]
        );
    }



    /**
     * Reset queue counters.
     */
    public function resetCounters(
        string $name
    ): bool {

        $queue = $this->find($name);


        if ($queue === null) {

            throw ResourceNotFoundException::missing(
                'simple-queue',
                [
                    'name' => $name,
                ]
            );
        }


        $query = (new Query('/queue/simple/reset-counters'))
            ->equal('.id', $queue['.id']);


        return $this->query->write($query);
    }



    /**
     * Search queues.
     *
     * @return array<int,array<string,mixed>>
     */
    public function search(
        string $keyword
    ): array {

        $queues = $this->getAll();


        return array_values(
            array_filter(
                $queues,
                function (array $queue) use ($keyword) {

                    return isset($queue['name'])
                        &&
                        str_contains(
                            strtolower($queue['name']),
                            strtolower($keyword)
                        );
                }
            )
        );
    }



    /**
     * Get queue statistics.
     *
     * @return array<string,mixed>
     */
    public function statistics(
        string $name
    ): array {

        $queue = $this->find($name);


        if ($queue === null) {

            throw ResourceNotFoundException::missing(
                'simple-queue',
                [
                    'name' => $name,
                ]
            );
        }


        return [
            'name' =>
            $queue['name'] ?? null,

            'target' =>
            $queue['target'] ?? null,

            'max_limit' =>
            $queue['max-limit'] ?? null,

            'limit_at' =>
            $queue['limit-at'] ?? null,

            'bytes_in' =>
            (int) ($queue['bytes-in'] ?? 0),

            'bytes_out' =>
            (int) ($queue['bytes-out'] ?? 0),

            'disabled' => ($queue['disabled'] ?? 'false') === 'true',
        ];
    }
}
