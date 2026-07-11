<?php

declare(strict_types=1);

namespace App\Services\Network\Providers\MikroTik;

use RouterOS\Client;
use RouterOS\Query;
use Illuminate\Support\Facades\Log;

class MikroTikConnectionService
{
    protected ?Client $client = null;



    /**
     * Connect to MikroTik RouterOS.
     */
    public function connect(
        string $host,
        string $username,
        string $password,
        int $port = 8728
    ): bool {

        try {

            $this->client = new Client([
                'host' => $host,
                'user' => $username,
                'pass' => $password,
                'port' => $port,
            ]);


            /*
             * Connection test
             */
            $this->client
                ->query(
                    new Query('/system/resource/print')
                )
                ->read();



            return true;
        } catch (\Throwable $e) {


            Log::error(
                'MikroTik connection failed',
                [
                    'host' => $host,
                    'error' => $e->getMessage(),
                ]
            );


            $this->client = null;


            return false;
        }
    }



    /**
     * Get active RouterOS client.
     */
    public function client(): ?Client
    {
        return $this->client;
    }



    /**
     * Check connection state.
     */
    public function isConnected(): bool
    {
        return $this->client !== null;
    }



    /**
     * Disconnect current session.
     */
    public function disconnect(): void
    {
        $this->client = null;
    }



    /**
     * Execute connection health check.
     */
    public function ping(): bool
    {
        try {

            if (!$this->isConnected()) {
                return false;
            }


            $this->client
                ->query(
                    new Query('/system/resource/print')
                )
                ->read();


            return true;
        } catch (\Throwable $e) {


            Log::warning(
                'MikroTik health check failed',
                [
                    'error' => $e->getMessage(),
                ]
            );


            return false;
        }
    }
}
