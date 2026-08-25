<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Resources\SingletonResource;
use Illuminate\Contracts\Container\Container;
use Tests\TestCase;

final class SingletonResourceTest extends TestCase
{
    public function test_it_registers_singleton_bindings_with_the_container(): void
    {
        $resource = new SingletonResource([
            SingletonResourceTestContract::class => SingletonResourceTestImplementation::class,
        ]);

        $resource->register(
            $this->app->make(
                \App\Core\Kernel\Contracts\ModuleRegistrarInterface::class,
            ),
        );

        $first = $this->app->make(
            SingletonResourceTestContract::class,
        );

        $second = $this->app->make(
            SingletonResourceTestContract::class,
        );

        self::assertInstanceOf(
            SingletonResourceTestImplementation::class,
            $first,
        );

        self::assertSame(
            $first,
            $second,
        );
    }

    public function test_it_compiles_singleton_bindings(): void
    {
        $resource = new SingletonResource([
            SingletonResourceTestContract::class => SingletonResourceTestImplementation::class,
        ]);

        self::assertSame(
            [
                'type' => 'singletons',
                'bindings' => [
                    SingletonResourceTestContract::class =>
                        SingletonResourceTestImplementation::class,
                ],
            ],
            $resource->compile(),
        );
    }
}

interface SingletonResourceTestContract
{
}

final class SingletonResourceTestImplementation implements SingletonResourceTestContract
{
}
