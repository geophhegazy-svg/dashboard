<?php

declare(strict_types=1);

namespace App\Contracts\Network;

interface NetworkProviderInterface
{
    /**
     * Connect to network device.
     */
    public function connect(
        string $host,
        string $username,
        string $password,
        int $port = 8728
    ): bool;



    /**
     * Disconnect device.
     */
    public function disconnect(): void;



    /**
     * Check connection status.
     */
    public function isConnected(): bool;



    /**
     * Get provider name.
     */
    public function name(): string;



    /**
     * Get provider capabilities.
     *
     * @return array<int,string>
     */
    public function capabilities(): array;
}
