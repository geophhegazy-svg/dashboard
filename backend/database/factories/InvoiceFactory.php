<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceFactory extends Factory
{
    use HasFactory;
    
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
