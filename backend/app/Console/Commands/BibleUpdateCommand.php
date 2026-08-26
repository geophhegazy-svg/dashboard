<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Modules\Documentation\Application\Knowledge\KnowledgeExporter;
use Illuminate\Console\Command;

class BibleUpdateCommand extends Command
{
    protected $signature = 'bible:update';

    protected $description = 'Update Project Bible documentation';

    public function handle(KnowledgeExporter $exporter): int
    {
        $exporter->export();

        $this->info('Project Bible updated successfully.');

        return self::SUCCESS;
    }
}
