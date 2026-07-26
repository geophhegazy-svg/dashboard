<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Console\Kernel;


use App\Core\Kernel\Inspector\KernelInspector;
use Illuminate\Console\Command;

final class KernelModulesCommand extends Command
{
    protected $signature = 'kernel:modules';

    protected $description =
    'Display discovered kernel modules.';

    public function __construct(
        private readonly KernelInspector $inspector,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $rows = [];

        foreach (
            $this->inspector->modules()
            as $module
        ) {

            $rows[] = [
                $module->name(),
                class_basename(
                    $module->class(),
                ),
                $module->dependencyCount(),
                $module->resourceCount(),
            ];
        }

        $this->table(
            [
                'Module',
                'Class',
                'Dependencies',
                'Resources',
            ],
            $rows,
        );

        $statistics = $this->inspector->statistics();

        $this->newLine();

        $this->info(
            sprintf(
                'Modules: %d | Dependencies: %d | Resources: %d',
                $statistics->modules(),
                $statistics->dependencies(),
                $statistics->resources(),
            ),
        );

        return self::SUCCESS;
    }
}
