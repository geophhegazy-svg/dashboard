<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Ticket\Infrastructure\Persistence\Models;

use App\Models\User;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Infrastructure\Persistence\Models\TicketReply;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketReply>
 */
final class TicketReplyFactory extends Factory
{
    protected $model = TicketReply::class;

    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'customer_id' => null,
            'user_id' => User::factory(),
            'message' => fake()->paragraph(),
            'is_staff' => true,
            'sent_at' => now(),
        ];
    }

    public function fromCustomer(): static
    {
        return $this->state(fn () => [
            'customer_id' => Customer::factory(),
            'user_id' => null,
            'is_staff' => false,
        ]);
    }

    public function fromStaff(): static
    {
        return $this->state(fn () => [
            'customer_id' => null,
            'user_id' => User::factory(),
            'is_staff' => true,
        ]);
    }
}
