<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Core\Kernel\Contracts\ModuleLoaderInterface;
use App\Core\Kernel\Contracts\KernelValidatorInterface;

final class KernelValidateCommand extends Command
{
    protected $signature = 'kernel:validate';

    protected $description = 'Validate the EgyptNet Kernel module graph.';

    public function __construct(
        private readonly ModuleLoaderInterface $loader,
        private readonly KernelValidatorInterface $validator,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $registry = $this->loader->load();

        $result = $this->validator->validate(
            $registry,
        );

        if ($result->isValid()) {

            $this->info(
                'Kernel validation passed.'
            );

            return self::SUCCESS;
        }

        $this->error(
            sprintf(
                'Kernel validation failed (%d errors).',
                $result->errorCount(),
            ),
        );

        foreach ($result->errors() as $error) {

            $this->line(
                $error->format(),
            );
        }

        return self::FAILURE;
    }
}
