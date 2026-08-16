<?php

declare(strict_types=1);

namespace Database\Factories\Modules\Payment\Infrastructure\Persistence\Models;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
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
