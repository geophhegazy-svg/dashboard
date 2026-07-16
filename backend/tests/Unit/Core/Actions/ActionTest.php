<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Actions;

use App\Core\Actions\Action;
use App\Core\Results\SuccessResult;
use PHPUnit\Framework\TestCase;

final class ActionTest extends TestCase
{
    public function test_run_returns_result(): void
    {
        $action = new class extends Action
        {
            protected function execute(
                mixed ...$arguments,
            ): \App\Core\Results\Result {

                return SuccessResult::make(
                    message: 'Action executed successfully',
                );
            }
        };

        $result = $action->run();

        $this->assertTrue(
            $result->successful()
        );

        $this->assertSame(
            'Action executed successfully',
            $result->message()
        );
    }
}
