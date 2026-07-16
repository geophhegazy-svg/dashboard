<?php

declare(strict_types=1);

namespace Tests\Unit\Core\ValueObjects;

use App\Core\ValueObjects\EmailAddress;
use InvalidArgumentException;
use Tests\TestCase;

final class EmailAddressTest extends TestCase
{
    public function test_creates_valid_email(): void
    {
        $email = EmailAddress::make('Admin@EgyptNet.COM');

        $this->assertSame(
            'admin@egyptnet.com',
            $email->value(),
        );
    }

    public function test_extracts_domain(): void
    {
        $this->assertSame(
            'egyptnet.com',
            EmailAddress::make(
                'admin@egyptnet.com'
            )->domain(),
        );
    }

    public function test_extracts_local_part(): void
    {
        $this->assertSame(
            'admin',
            EmailAddress::make(
                'admin@egyptnet.com'
            )->localPart(),
        );
    }

    public function test_equals(): void
    {
        $this->assertTrue(
            EmailAddress::make('ADMIN@EGYPTNET.COM')
                ->equals(
                    EmailAddress::make('admin@egyptnet.com')
                )
        );
    }

    public function test_invalid_email_throws_exception(): void
    {
        $this->expectException(
            InvalidArgumentException::class
        );

        EmailAddress::make('invalid-email');
    }

    public function test_to_string(): void
    {
        $this->assertSame(
            'admin@egyptnet.com',
            (string) EmailAddress::make(
                'admin@egyptnet.com'
            ),
        );
    }
}
