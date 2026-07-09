<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Task;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'priority' => fake()->randomElement([
                'low',
                'medium',
                'high',
                'critical',
            ]),
            'status' => 'pending',
            'started_at' => null,
            'completed_at' => null,
            'cancelled_at' => null,
            'meta' => [],
        ];
    }

    public function completed(): static
    {
        return $this->state(fn() => [
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn() => [
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn() => [
            'status' => 'in_progress',
            'started_at' => now(),
        ]);
    }
}
