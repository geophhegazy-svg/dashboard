<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Modules\Subscription\Presentation\Console\Commands\AutoExpireSubscriptionsCommand;
use App\Modules\Subscription\Application\Orchestrators\AutoExpireSubscriptionsOrchestratorInterface;
use Mockery;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

final class AutoExpireSubscriptionsCommandTest extends TestCase
{
    public function test_command_executes_orchestrator_and_reports_count(): void
    {
        $orchestrator = Mockery::mock(
            AutoExpireSubscriptionsOrchestratorInterface::class
        );

        $orchestrator
            ->shouldReceive('execute')
            ->once()
            ->andReturn(3);

        $command = new AutoExpireSubscriptionsCommand(
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
            'تم إنهاء 3 اشتراك منتهٍ.',
            $tester->getDisplay(),
        );
    }
}
