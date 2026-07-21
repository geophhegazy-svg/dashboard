<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\Kernel\Resources\ScheduleResource;
use Illuminate\Console\Scheduling\Schedule;
use Tests\TestCase;

final class ScheduleResourceTest extends TestCase
{
    public function test_it_registers_module_schedule_events(): void
    {
        $schedule = $this->app->make(Schedule::class);
        $eventCount = count($schedule->events());

        $resource = new ScheduleResource(
            static function (Schedule $schedule): void {
                $schedule->call(static fn (): null => null)->everyMinute();
            },
        );

        $resource->register();

        $this->assertCount($eventCount + 1, $schedule->events());
    }
}
