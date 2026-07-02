<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentFactory extends Factory
{
    use HasFactory;

    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),

            'invoice_id' => Invoice::factory(),

            'amount' => fake()->numberBetween(100, 1000),

            'payment_date' => now(),

            'payment_method' => 'cash',

            'reference_number' => fake()->uuid(),

            'notes' => fake()->sentence(),
        ];
    }
}
