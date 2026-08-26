<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Invoice;

use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class InvoiceServiceRenewalTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_renewal_is_idempotent_by_renewal_key(): void
    {
        $subscription = Subscription::factory()->create([
            'monthly_price' => 350,
        ]);

        $service = $this->app->make(
            InvoiceServiceInterface::class
        );

        $data = [
            'tenant_id'       => $subscription->tenant_id,
            'customer_id'     => $subscription->customer_id,
            'subscription_id' => $subscription->id,
            'renewal_key'     => 'renewal-contract-001',
            'amount'          => 350,
            'status'          => 'pending',
            'due_date'        => $subscription->end_date,
        ];

        $first = $service->createRenewal($data);

        $second = $service->createRenewal($data);

        $this->assertInstanceOf(
            Invoice::class,
            $first
        );

        $this->assertSame(
            $first->id,
            $second->id
        );

        $this->assertSame(
            'renewal-contract-001',
            $second->renewal_key
        );

        $this->assertSame(
            1,
            Invoice::where(
                'renewal_key',
                'renewal-contract-001'
            )->count()
        );
    }

    public function test_create_renewal_creates_a_new_invoice_for_a_new_key(): void
    {
        $subscription = Subscription::factory()->create([
            'monthly_price' => 350,
        ]);

        $service = $this->app->make(
            InvoiceServiceInterface::class
        );

        $baseData = [
            'tenant_id'       => $subscription->tenant_id,
            'customer_id'     => $subscription->customer_id,
            'subscription_id' => $subscription->id,
            'amount'          => 350,
            'status'          => 'pending',
            'due_date'        => $subscription->end_date,
        ];

        $first = $service->createRenewal([
            ...$baseData,
            'renewal_key' => 'renewal-contract-001',
        ]);

        $second = $service->createRenewal([
            ...$baseData,
            'renewal_key' => 'renewal-contract-002',
        ]);

        $this->assertNotSame(
            $first->id,
            $second->id
        );

        $this->assertSame(
            2,
            Invoice::where(
                'subscription_id',
                $subscription->id
            )->count()
        );

        $this->assertDatabaseHas('invoices', [
            'renewal_key' => 'renewal-contract-001',
        ]);

        $this->assertDatabaseHas('invoices', [
            'renewal_key' => 'renewal-contract-002',
        ]);
    }
}
