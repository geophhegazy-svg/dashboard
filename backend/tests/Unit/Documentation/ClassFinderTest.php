<?php

declare(strict_types=1);

namespace Tests\Unit\Documentation;

use App\Modules\Documentation\Application\Scanner\ClassFinder;
use Tests\TestCase;

class ClassFinderTest extends TestCase
{
    public function test_find_returns_fqcn(): void
    {
        $finder = new ClassFinder();

        $class = $finder->find(
            app_path('Modules/Customer/Infrastructure/Persistence/Models/Customer.php')
        );

        $this->assertEquals(
            'App\\Modules\\Customer\\Infrastructure\\Persistence\\Models\\Customer',
            $class
        );
    }
}
