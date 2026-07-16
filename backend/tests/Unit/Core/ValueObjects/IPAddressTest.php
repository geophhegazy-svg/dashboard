<?php

declare(strict_types=1);

namespace Tests\Unit\Core\ValueObjects;

use App\Core\ValueObjects\IPAddress;
use InvalidArgumentException;
use Tests\TestCase;

final class IPAddressTest extends TestCase
{
    public function test_creates_valid_ipv4(): void
    {
        $ip = IPAddress::make('192.168.1.1');

        $this->assertSame('192.168.1.1', $ip->value());
        $this->assertTrue($ip->isIpv4());
        $this->assertFalse($ip->isIpv6());
    }

    public function test_creates_valid_ipv6(): void
    {
        $ip = IPAddress::make('2001:db8::1');

        $this->assertTrue($ip->isIpv6());
        $this->assertFalse($ip->isIpv4());
    }

    public function test_equals(): void
    {
        $this->assertTrue(
            IPAddress::make('10.0.0.1')
                ->equals(
                    IPAddress::make('10.0.0.1')
                )
        );
    }

    public function test_invalid_ip_throws_exception(): void
    {
        $this->expectException(
            InvalidArgumentException::class
        );

        IPAddress::make('invalid-ip');
    }

    public function test_to_string(): void
    {
        $ip = IPAddress::make('8.8.8.8');

        $this->assertSame(
            '8.8.8.8',
            (string) $ip,
        );
    }
}
