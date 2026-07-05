<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Reflection\ClassReflector;
use Tests\TestCase;

class ClassReflectorTest extends TestCase
{
    public function test_reflects_invoice_number_service(): void
    {
        $reflector = new ClassReflector();

        $methods = $reflector->methods(
            \App\Services\InvoiceNumberService::class
        );

        $this->assertNotEmpty($methods);

        $this->assertEquals(
            'generate',
            $methods[0]['name']
        );
    }
}
