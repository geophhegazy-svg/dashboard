<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Ticket\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Models\User;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
final class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'customer_id' => Customer::factory(),
            'user_id' => null,
            'ticket_number' => 'TKT-' . fake()->unique()->numerify('##########'),
            'subject' => fake()->sentence(5),
            'description' => fake()->paragraph(),
            'priority' => fake()->randomElement([
                'low',
                'medium',
                'high',
                'critical',
            ]),
            'status' => 'open',
            'opened_at' => now(),
            'closed_at' => null,
            'notes' => null,
        ];
    }

    public function assigned(): static
    {
        return $this->state(fn () => [
            'user_id' => User::factory(),
        ]);
    }

    public function closed(): static
    {
        return $this->state(fn () => [
            'status' => 'closed',
            'closed_at' => now(),
        ]);
    }

    public function resolved(): static
    {
        return $this->state(fn () => [
            'status' => 'resolved',
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn () => [
            'status' => 'in_progress',
        ]);
    }

    public function highPriority(): static
    {
        return $this->state(fn () => [
            'priority' => 'high',
        ]);
    }
}
