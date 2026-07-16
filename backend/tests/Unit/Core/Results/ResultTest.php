<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Results;

use App\Core\Results\SuccessResult;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ResultTest extends TestCase
{
    #[Test]
    public function it_contains_default_structure(): void
    {
        $result = SuccessResult::make();

        $array = $result->toArray();

        $this->assertArrayHasKey('success', $array);
        $this->assertArrayHasKey('message', $array);
        $this->assertArrayHasKey('code', $array);
        $this->assertArrayHasKey('data', $array);
        $this->assertArrayHasKey('errors', $array);
        $this->assertArrayHasKey('meta', $array);
    }

    #[Test]
    public function it_can_attach_metadata(): void
    {
        $result = SuccessResult::make()
            ->withMeta([
                'tenant_id' => 5,
                'trace_id' => 'abc123',
            ]);

        $this->assertEquals(
            5,
            $result->meta()['tenant_id']
        );

        $this->assertEquals(
            'abc123',
            $result->meta()['trace_id']
        );
    }
}
