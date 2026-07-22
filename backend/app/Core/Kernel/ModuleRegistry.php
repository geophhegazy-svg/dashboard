<?php

declare(strict_types=1);

namespace App\Core\Kernel;

use App\Core\Kernel\Contracts\ModuleContract;
use App\Core\Kernel\Contracts\ModuleRegistrarInterface;
use App\Core\Kernel\Resources\CommandResource;
use App\Core\Kernel\Resources\ScheduleResource;
use Illuminate\Console\Application as Artisan;
use Illuminate\Console\Scheduling\Schedule;

final class ModuleRegistry
{
    /**
     * @var array<int,ModuleContract>
     */
    private array $modules = [];


    /**
     * @var array<int,CommandResource>
     */
    private array $commands = [];


    /**
     * @var array<int,ScheduleResource>
     */
    private array $schedules = [];


    public function __construct(
        private readonly ModuleRegistrarInterface $registrar
    ) {}


    public function register(
        ModuleContract $module
    ): void {

        $this->modules[] = $module;

        $manifest = $module->manifest();

        foreach ($manifest->resources() as $resource) {

            $resource->register(
                $this->registrar
            );


            if ($resource instanceof CommandResource) {
                $this->commands[] = $resource;
            }


            if ($resource instanceof ScheduleResource) {
                $this->schedules[] = $resource;
            }
        }
    }


    public function boot(): void
    {
        $this->registerCommands();

        $this->registerSchedules();
    }


    private function registerCommands(): void
    {
        foreach ($this->commands as $resource) {

            Artisan::starting(
                function (Artisan $artisan) use ($resource) {

                    $artisan->resolveCommands(
                        $resource->commands()
                    );
                }
            );
        }
    }


    private function registerSchedules(): void
    {
        if (! app()->bound(Schedule::class)) {
            return;
        }

        foreach ($this->schedules as $resource) {

            $resource->register(
                $this->registrar
            );
        }
    }


    /**
     * @return array<int,ModuleContract>
     */
    public function all(): array
    {
        return $this->modules;
    }
}
