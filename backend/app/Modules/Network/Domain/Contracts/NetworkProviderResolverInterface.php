<?php

declare(strict_types=1);

namespace App\Modules\Network\Domain\Contracts;

interface NetworkProviderResolverInterface
{
    public function resolve(
        string $type
    ): NetworkProviderInterface;

    public function resolveByName(
        string $name
    ): NetworkProviderInterface;

    public function register(
        string $name,
        string $provider
    ): void;

    /**
     * @return array<int,string>
     */
    public function available(): array;
}
