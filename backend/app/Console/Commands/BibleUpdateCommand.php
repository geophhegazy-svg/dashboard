<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Documentation\ProjectBibleService;

class BibleUpdateCommand extends Command
{
    protected $signature = 'bible:update';

    protected $description = 'Update Project Bible documentation';

    public function handle(ProjectBibleService $service): int
    {
        $markdown = $service->generate();

        file_put_contents(
            base_path('docs/generated/PROJECT_BIBLE.md'),
            $markdown
        );

        $this->info('Project Bible updated successfully.');

        return self::SUCCESS;
    }
}
