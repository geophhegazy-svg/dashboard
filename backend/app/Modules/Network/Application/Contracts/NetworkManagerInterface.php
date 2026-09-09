<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Contracts;

use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;

interface NetworkManagerInterface
{
    public function connect(int $deviceId): bool;

    public function disconnect(): void;

    public function provider(): ?NetworkProviderInterface;

    public function connected(): bool;

    public function providerName(): ?string;

    /**
     * @return array<int,string>
     */
    public function capabilities(): array;
}
