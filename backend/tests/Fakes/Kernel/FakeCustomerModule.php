<?php

declare(strict_types=1);

namespace Tests\Fakes\Kernel;

final class FakeCustomerModule extends FakeModule
{
    public function __construct()
    {
        parent::__construct(
            'Customer',
        );
    }
}
