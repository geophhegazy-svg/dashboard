<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Network\Infrastructure\Providers;

use App\Modules\Network\Domain\Contracts\NetworkProviderInterface;
use App\Modules\Network\Domain\Contracts\NetworkProviderResolverInterface;
use App\Modules\Network\Infrastructure\Providers\MikroTik\MikroTikProvider;
use App\Modules\Network\Infrastructure\Providers\NetworkProviderResolver;
use Tests\TestCase;
use RuntimeException;

final class NetworkProviderResolverTest extends TestCase
{
    public function test_it_implements_the_resolver_contract(): void
    {
        $resolver = new NetworkProviderResolver();

        self::assertInstanceOf(
            NetworkProviderResolverInterface::class,
            $resolver
        );
    }

    public function test_it_resolves_mikrotik_provider_by_type(): void
    {
        $resolver = app(NetworkProviderResolverInterface::class);

        $provider = $resolver->resolve('mikrotik');

        self::assertInstanceOf(
            NetworkProviderInterface::class,
            $provider
        );

        self::assertInstanceOf(
            MikroTikProvider::class,
            $provider
        );
    }

    public function test_it_resolves_provider_case_insensitively(): void
    {
        $resolver = app(NetworkProviderResolverInterface::class);

        $provider = $resolver->resolveByName('MIKROTIK');

        self::assertInstanceOf(
            MikroTikProvider::class,
            $provider
        );
    }

    public function test_it_reports_available_providers(): void
    {
        $resolver = app(NetworkProviderResolverInterface::class);

        self::assertContains(
            'mikrotik',
            $resolver->available()
        );
    }

    public function test_it_rejects_unsupported_provider(): void
    {
        $resolver = app(NetworkProviderResolverInterface::class);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            'Unsupported network provider: unsupported'
        );

        $resolver->resolve('unsupported');
    }
}
