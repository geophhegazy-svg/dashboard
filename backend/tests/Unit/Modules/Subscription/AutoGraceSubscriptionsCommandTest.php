<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Console\Commands\AutoGraceSubscriptionsCommand;
use App\Modules\Subscription\Application\Orchestrators\AutoGraceSubscriptionsOrchestratorInterface;
use Mockery;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

final class AutoGraceSubscriptionsCommandTest extends TestCase
{
    public function test_command_executes_orchestrator_and_reports_count(): void
    {
        $orchestrator = Mockery::mock(
            AutoGraceSubscriptionsOrchestratorInterface::class
        );

        $orchestrator
            ->shouldReceive('execute')
            ->once()
            ->andReturn(3);

        $command = new AutoGraceSubscriptionsCommand(
            $orchestrator,
        );

        $command->setLaravel($this->app);

        $tester = new CommandTester($command);

        $exitCode = $tester->execute([]);

        $this->assertSame(
            0,
            $exitCode,
        );

        $this->assertStringContainsString(
            'تم إدخال 3 اشتراك في فترة السماح.',
            $tester->getDisplay(),
        );
    }
}
