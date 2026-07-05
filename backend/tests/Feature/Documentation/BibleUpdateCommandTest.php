<?php

namespace Tests\Feature\Documentation;

use Tests\TestCase;

class BibleUpdateCommandTest extends TestCase
{
    public function test_bible_update_command_exists(): void
    {
        $this->artisan('bible:update')
            ->assertExitCode(0);
    }
}
