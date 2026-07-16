<?php

declare(strict_types=1);

namespace Tests\Unit\Core\ValueObjects;

use App\Core\ValueObjects\Bandwidth;
use InvalidArgumentException;
use Tests\TestCase;

final class BandwidthTest extends TestCase
{
    public function test_create_from_kbps(): void
    {
        $bandwidth = Bandwidth::fromKbps(512);

        $this->assertSame(512, $bandwidth->kbps());
        $this->assertSame('512 Kbps', $bandwidth->format());
    }

    public function test_create_from_mbps(): void
    {
        $bandwidth = Bandwidth::fromMbps(20);

        $this->assertSame(20000, $bandwidth->kbps());
        $this->assertSame(20.0, $bandwidth->mbps());
        $this->assertSame('20 Mbps', $bandwidth->format());
    }

    public function test_equals(): void
    {
        $this->assertTrue(
            Bandwidth::fromMbps(10)
                ->equals(
                    Bandwidth::fromKbps(10000)
                )
        );
    }

    public function test_to_string(): void
    {
        $this->assertSame(
            '5000',
            (string) Bandwidth::fromMbps(5),
        );
    }

    public function test_invalid_bandwidth_throws_exception(): void
    {
        $this->expectException(
            InvalidArgumentException::class
        );

        Bandwidth::fromKbps(0);
    }
}
