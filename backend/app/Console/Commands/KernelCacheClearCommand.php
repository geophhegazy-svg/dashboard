<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use Illuminate\Console\Command;

final class KernelCacheClearCommand extends Command
{
    protected $signature = 'kernel:cache-clear';

    protected $description = 'Clear compiled Kernel manifest cache';

    public function __construct(
        private readonly ModuleManifestCacheInterface $cache,
    ) {
        parent::__construct();
    }


    public function handle(): int
    {
        if (! $this->cache->has()) {

            $this->info(
                'Kernel manifest cache is already empty.'
            );

            return self::SUCCESS;
        }


        $this->cache->clear();


        $this->info(
            'Kernel manifest cache cleared successfully.'
        );


        return self::SUCCESS;
    }
}
