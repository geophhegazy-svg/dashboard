<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Results;

use App\Core\Results\SuccessResult;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SuccessResultTest extends TestCase
{
    #[Test]
    public function it_creates_success_result(): void
    {
        $result = SuccessResult::make(
            data: ['id' => 1],
            message: 'Created'
        );

        $this->assertTrue($result->successful());

        $this->assertFalse($result->failed());

        $this->assertEquals(
            'Created',
            $result->message()
        );

        $this->assertEquals(
            ['id' => 1],
            $result->data()
        );

        $this->assertEquals(
            [],
            $result->errors()
        );

        $this->assertNull(
            $result->code()
        );
    }

    #[Test]
    public function it_converts_to_array(): void
    {
        $result = SuccessResult::make(
            data: ['name' => 'Ahmed'],
            message: 'OK'
        );

        $array = $result->toArray();

        $this->assertTrue($array['success']);

        $this->assertEquals(
            'OK',
            $array['message']
        );

        $this->assertEquals(
            'Ahmed',
            $array['data']['name']
        );
    }
}
