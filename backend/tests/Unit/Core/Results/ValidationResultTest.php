<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Results;

use App\Core\Results\ValidationResult;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ValidationResultTest extends TestCase
{
    #[Test]
    public function it_contains_validation_errors(): void
    {
        $result = ValidationResult::make(
            errors: [
                'username' => [
                    'Username already exists',
                ],
                'email' => [
                    'Email is invalid',
                ],
            ]
        );

        $this->assertFalse(
            $result->successful()
        );

        $this->assertTrue(
            $result->failed()
        );

        $this->assertTrue(
            $result->has('username')
        );

        $this->assertFalse(
            $result->has('password')
        );

        $this->assertEquals(
            'Username already exists',
            $result->first('username')
        );

        $this->assertEquals(
            'Email is invalid',
            $result->first('email')
        );

        $this->assertNull(
            $result->first('password')
        );
    }

    #[Test]
    public function it_exports_errors_to_array(): void
    {
        $result = ValidationResult::make(
            errors: [
                'name' => [
                    'Required',
                ],
            ]
        );

        $array = $result->toArray();

        $this->assertFalse(
            $array['success']
        );

        $this->assertEquals(
            'Validation failed',
            $array['message']
        );

        $this->assertEquals(
            'VALIDATION_FAILED',
            $array['code']
        );

        $this->assertArrayHasKey(
            'name',
            $array['errors']
        );
    }
}
