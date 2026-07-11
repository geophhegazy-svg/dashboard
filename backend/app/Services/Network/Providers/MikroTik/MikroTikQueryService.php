<?php

declare(strict_types=1);

namespace App\Services\Network\Providers\MikroTik;

use Illuminate\Support\Facades\Log;
use RouterOS\Client;
use RouterOS\Query;
use RuntimeException;
use Throwable;

class MikroTikQueryService
{
    public function __construct(
        protected MikroTikConnectionService $connection
    ) {}



    /**
     * Execute RouterOS query.
     *
     * @return array<int,array<string,mixed>>
     */
    public function execute(
        Query $query
    ): array {

        try {

            return $this->client()
                ->query($query)
                ->read();
        } catch (Throwable $e) {


            $this->logFailure(
                'query',
                $query,
                $e
            );


            return [];
        }
    }



    /**
     * Execute query and return first result.
     *
     * @return array<string,mixed>|null
     */
    public function first(
        Query $query
    ): ?array {

        return $this->execute($query)[0] ?? null;
    }



    /**
     * Execute write command.
     */
    public function write(
        Query $query
    ): bool {

        try {

            $this->client()
                ->query($query)
                ->read();


            return true;
        } catch (Throwable $e) {


            $this->logFailure(
                'write',
                $query,
                $e
            );


            return false;
        }
    }



    /**
     * Get connected RouterOS client.
     */
    protected function client(): Client
    {

        $client = $this->connection->client();


        if ($client === null) {

            throw new RuntimeException(
                'MikroTik client is not connected'
            );
        }


        return $client;
    }



    /**
     * Log RouterOS failures.
     */
    protected function logFailure(
        string $operation,
        Query $query,
        Throwable $exception
    ): void {

        Log::error(
            'MikroTik operation failed',
            [
                'operation' => $operation,

                'query' =>
                $query->getQuery(),

                'error' =>
                $exception->getMessage(),
            ]
        );
    }
}
