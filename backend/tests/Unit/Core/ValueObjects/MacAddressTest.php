<?php

declare(strict_types=1);

namespace Tests\Unit\Core\ValueObjects;

use App\Core\ValueObjects\MacAddress;
use InvalidArgumentException;
use Tests\TestCase;

final class MacAddressTest extends TestCase
{
    public function test_creates_valid_mac(): void
    {
        $mac = MacAddress::make(
            'aa-bb-cc-dd-ee-ff'
        );

        $this->assertSame(
            'AA:BB:CC:DD:EE:FF',
            $mac->value(),
        );
    }

    public function test_equals(): void
    {
        $this->assertTrue(
            MacAddress::make('AA:BB:CC:DD:EE:FF')
                ->equals(
                    MacAddress::make('aa-bb-cc-dd-ee-ff')
                )
        );
    }

    public function test_detects_broadcast(): void
    {
        $this->assertTrue(
            MacAddress::make(
                'FF:FF:FF:FF:FF:FF'
            )->isBroadcast()
        );
    }

    public function test_detects_unicast(): void
    {
        $this->assertTrue(
            MacAddress::make(
                '00:11:22:33:44:55'
            )->isUnicast()
        );
    }

    public function test_invalid_mac_throws_exception(): void
    {
        $this->expectException(
            InvalidArgumentException::class
        );

        MacAddress::make('invalid');
    }

    public function test_to_string(): void
    {
        $this->assertSame(
            'AA:BB:CC:DD:EE:FF',
            (string) MacAddress::make(
                'AA:BB:CC:DD:EE:FF'
            ),
        );
    }
}
