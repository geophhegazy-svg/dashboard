<?php

declare(strict_types=1);

namespace Tests\Fakes\Kernel;

final class FakeSubscriptionModule extends FakeModule
{
    public function __construct()
    {
        parent::__construct(
            'Subscription',
        );
    }
}
