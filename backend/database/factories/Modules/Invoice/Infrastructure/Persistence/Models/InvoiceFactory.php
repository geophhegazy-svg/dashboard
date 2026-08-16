<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Invoice\Infrastructure\Persistence\Models;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),

            'customer_id' => Customer::factory(),

            'subscription_id' => Subscription::factory(),

            'invoice_number' => 'INV-' . fake()->unique()->numberBetween(10000, 99999),

            'amount' => fake()->numberBetween(100, 1000),

            'due_date' => now()->addMonth(),

            'status' => 'pending',

            'paid_at' => null,

            'notes' => fake()->sentence(),
        ];
    }
}
