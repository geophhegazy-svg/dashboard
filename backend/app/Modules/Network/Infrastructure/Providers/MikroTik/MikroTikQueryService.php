<?php

declare(strict_types=1);

namespace App\Modules\Network\Infrastructure\Providers\MikroTik;

use App\Exceptions\Network\QueryException;
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

            return $this->normalizeUtf8Rows(
                $this->client()
                    ->query($query)
                    ->read()
            );
        } catch (Throwable $e) {


            $this->logFailure(
                'query',
                $query,
                $e
            );

            throw QueryException::failed([
                'operation' => 'query',
                'query' => $query->getQuery(),
                'error' => $e->getMessage(),
            ]);
        }
    }



    /**
     * Remove invalid UTF-8 bytes from RouterOS response values.
     *
     * @param array<int,array<string,mixed>> $rows
     * @return array<int,array<string,mixed>>
     */
    private function normalizeUtf8Rows(array $rows): array
    {
        foreach ($rows as $rowIndex => $row) {
            foreach ($row as $key => $value) {
                $rows[$rowIndex][$key] = $this->normalizeUtf8Value($value);
            }
        }

        return $rows;
    }

    private function normalizeUtf8Value(mixed $value): mixed
    {
        if (is_string($value)) {
            if (mb_check_encoding($value, 'UTF-8')) {
                return $value;
            }

            $normalized = @iconv('UTF-8', 'UTF-8//IGNORE', $value);

            return $normalized === false ? '' : $normalized;
        }

        if (is_array($value)) {
            foreach ($value as $key => $item) {
                $value[$key] = $this->normalizeUtf8Value($item);
            }
        }

        return $value;
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
