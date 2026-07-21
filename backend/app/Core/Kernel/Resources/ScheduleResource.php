<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

use App\Core\Kernel\Contracts\ModuleResourceInterface;
use Closure;
use Illuminate\Console\Scheduling\Schedule;

final readonly class ScheduleResource implements ModuleResourceInterface
{
    /**
     * @param Closure(Schedule): void $schedule
     */
    public function __construct(
        private Closure $schedule,
    ) {}

    public function register(): void
    {
        ($this->schedule)(app(Schedule::class));
    }
}
