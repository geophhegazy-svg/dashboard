<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use Tests\TestCase;
use App\Core\Kernel\Resources\CommandResource;

final class CommandResourceTest extends TestCase
{
    public function test_it_exposes_module_commands(): void
    {
        $resource = new CommandResource([
            DummyCommand::class,
        ]);

        $this->assertSame(
            [
                DummyCommand::class,
            ],
            $resource->commands(),
        );
    }
}


final class DummyCommand {}
