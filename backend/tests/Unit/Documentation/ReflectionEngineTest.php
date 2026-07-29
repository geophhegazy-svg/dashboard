<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use PHPUnit\Framework\TestCase;
use App\Modules\Documentation\Application\Reflection\ReflectionEngine;

class ReflectionEngineTest extends TestCase
{
    public function test_reflect_invoice_service(): void
    {
        $engine = new ReflectionEngine();

        $reflection = $engine->reflect(
            \App\Modules\Invoice\Application\Services\InvoiceNumberService::class
        );

        $this->assertArrayHasKey('methods', $reflection);
        $this->assertArrayHasKey('properties', $reflection);
        $this->assertArrayHasKey('constructor', $reflection);
    }
}
