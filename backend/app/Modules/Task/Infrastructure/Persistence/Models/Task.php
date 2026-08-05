<?php

namespace App\Modules\Task\Infrastructure\Persistence\Models;

class Task extends \App\Models\Task
{
    protected static function newFactory()
    {
        return \Database\Factories\TaskFactory::new();
    }
}
