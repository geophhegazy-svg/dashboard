<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Events\KernelBooted;
use App\Core\Kernel\Events\KernelBooting;
use App\Core\Kernel\Events\ModuleBooted;
use App\Core\Kernel\Events\ModuleBooting;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

final class KernelLifecycleTest extends TestCase
{
    public function test_kernel_dispatches_lifecycle_events(): void
    {
        Event::fake([
            KernelBooting::class,
            KernelBooted::class,
            ModuleBooting::class,
            ModuleBooted::class,
        ]);

        $this->app
            ->make(
                \App\Core\Kernel\Contracts\KernelBootstrapperInterface::class
            )
            ->boot();

        Event::assertDispatched(KernelBooting::class);
        Event::assertDispatched(KernelBooted::class);
        Event::assertDispatched(ModuleBooting::class);
        Event::assertDispatched(ModuleBooted::class);
    }
}
