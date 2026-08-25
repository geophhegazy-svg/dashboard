<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Console\Commands\AutoRenewSubscriptionsCommand;
use App\Modules\Subscription\Application\Orchestrators\AutoRenewSubscriptionsOrchestratorInterface;
use Mockery;
use Symfony\Component\Console\Tester\CommandTester;
use Tests\TestCase;

final class AutoRenewSubscriptionsCommandTest extends TestCase
{
    public function test_command_executes_orchestrator_and_reports_count(): void
    {
        $orchestrator = Mockery::mock(
            AutoRenewSubscriptionsOrchestratorInterface::class
        );

        $orchestrator
            ->shouldReceive('execute')
            ->once()
            ->andReturn(3);

        $command = new AutoRenewSubscriptionsCommand(
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
            'تم تجديد 3 اشتراك تلقائياً.',
            $tester->getDisplay(),
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
