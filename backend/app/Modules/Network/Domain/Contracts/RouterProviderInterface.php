<?php

declare(strict_types=1);

namespace App\Modules\Network\Domain\Contracts;

interface RouterProviderInterface
{
    /**
     * Provider unique name.
     *
     * Examples:
     * mikrotik
     * huawei
     * ubiquiti
     * cisco
     */
    public function name(): string;

    /**
     * Provider display name.
     */
    public function label(): string;

    /**
     * Provider version.
     */
    public function version(): ?string;

    /**
     * Check provider availability.
     */
    public function isAvailable(): bool;
}
