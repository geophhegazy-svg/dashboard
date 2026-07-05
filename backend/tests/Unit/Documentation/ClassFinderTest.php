<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Services\Documentation\Scanner\ClassFinder;
use Tests\TestCase;

class ClassFinderTest extends TestCase
{
    public function test_find_returns_fqcn(): void
    {
        $finder = new ClassFinder();

        $class = $finder->find(
            app_path('Models/Customer.php')
        );

        $this->assertEquals(
            'App\\Models\\Customer',
            $class
        );
    }
}
