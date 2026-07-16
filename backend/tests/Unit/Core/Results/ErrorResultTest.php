<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Results;

use App\Core\Results\ErrorResult;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ErrorResultTest extends TestCase
{
    #[Test]
    public function it_creates_error_result(): void
    {
        $result = ErrorResult::make(
            message: 'Router Offline',
            code: 'NETWORK_OFFLINE'
        );

        $this->assertFalse($result->successful());

        $this->assertTrue($result->failed());

        $this->assertEquals(
            'Router Offline',
            $result->message()
        );

        $this->assertEquals(
            'NETWORK_OFFLINE',
            $result->code()
        );

        $this->assertEquals(
            [],
            $result->errors()
        );
    }

    #[Test]
    public function it_converts_to_array(): void
    {
        $result = ErrorResult::make(
            message: 'Failed',
            code: 'ERROR'
        );

        $array = $result->toArray();

        $this->assertFalse($array['success']);

        $this->assertEquals(
            'Failed',
            $array['message']
        );

        $this->assertEquals(
            'ERROR',
            $array['code']
        );
    }
}
