<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Exceptions;

use App\Core\Exceptions\PlatformException;
use PHPUnit\Framework\TestCase;

final class PlatformExceptionTest extends TestCase
{
    public function test_exception_stores_error_code(): void
    {
        $exception = new PlatformException(
            message: 'Router offline',
            errorCode: 'NETWORK_OFFLINE',
        );

        $this->assertSame(
            'NETWORK_OFFLINE',
            $exception->errorCode(),
        );
    }

    public function test_exception_array_representation(): void
    {
        $exception = new PlatformException(
            message: 'Router offline',
            errorCode: 'NETWORK_OFFLINE',
        );

        $this->assertSame(
            [
                'message' => 'Router offline',
                'code' => 'NETWORK_OFFLINE',
            ],
            $exception->toArray(),
        );
    }
}
