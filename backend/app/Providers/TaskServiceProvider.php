<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\TaskInterface;
use App\Services\TaskManager;
use Illuminate\Support\ServiceProvider;

class TaskServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            TaskInterface::class,
            TaskManager::class
        );
    }

    public function boot(): void
    {
        //
    }
}
