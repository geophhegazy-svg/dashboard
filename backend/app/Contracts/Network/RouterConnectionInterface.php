<?php

declare(strict_types=1);

namespace App\Contracts\Network;

interface RouterConnectionInterface
{
    /**
     * Connect to router provider.
     */
    public function connect(
        string $host,
        string $username,
        string $password,
        int $port = 8728
    ): bool;


    /**
     * Reconnect using previous configuration.
     */
    public function reconnect(): bool;


    /**
     * Disconnect current session.
     */
    public function disconnect(): void;


    /**
     * Check connection state.
     */
    public function isConnected(): bool;


    /**
     * Execute operation using active connection.
     */
    public function execute(callable $callback): mixed;
}
