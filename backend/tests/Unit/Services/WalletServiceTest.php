<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Subscription;
use App\Models\WalletTransaction;
use App\Services\Wallet\WalletService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WalletServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_deposit_increases_wallet_balance_and_creates_transaction(): void
    {
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 100,
        ]);

        WalletService::deposit(
            subscription: $subscription,
            amount: 50,
            description: 'Test deposit',
            reference: 'REF-001'
        );

        $subscription->refresh();

        $this->assertEquals(150, $subscription->wallet_balance);

        $this->assertDatabaseHas('wallet_transactions', [
            'tenant_id' => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'amount' => 50,
            'description' => 'Test deposit',
        ]);
    }

    public function test_deduct_decreases_wallet_balance_and_creates_transaction(): void
    {
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 100,
        ]);

        WalletService::deduct(
            subscription: $subscription,
            amount: 40,
            description: 'Test deduct',
            reference: 'REF-002'
        );

        $subscription->refresh();

        // التأكد من الرصيد
        $this->assertEquals(60, $subscription->wallet_balance);

        // التأكد من تسجيل العملية
        $this->assertDatabaseHas('wallet_transactions', [
            'tenant_id' => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'amount' => 40,
            'type' => 'deduct',
            'description' => 'Test deduct',
        ]);
    }

    public function test_deduct_fails_when_balance_is_insufficient(): void
    {
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 30,
        ]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Insufficient wallet balance.');

        WalletService::deduct(
            subscription: $subscription,
            amount: 50,
            description: 'Test insufficient balance',
            reference: 'REF-003'
        );

        // تأكيد عدم تغيير الرصيد
        $this->assertDatabaseMissing('wallet_transactions', [
            'tenant_id' => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'description' => 'Test insufficient balance',
        ]);
    }

    public function test_deduct_fails_with_invalid_amount(): void
    {
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 100,
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount must be greater than zero.');

        WalletService::deduct(
            subscription: $subscription,
            amount: 0,
            description: 'Invalid amount test',
            reference: 'REF-004'
        );
    }

    public function test_deduct_fails_with_negative_amount(): void
    {
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 100,
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount must be greater than zero.');

        WalletService::deduct(
            subscription: $subscription,
            amount: -10,
            description: 'Negative amount test',
            reference: 'REF-005'
        );
    }

    public function test_deposit_creates_correct_wallet_transaction(): void
    {
        $subscription = Subscription::factory()->create([
            'wallet_balance' => 100,
        ]);

        WalletService::deposit(
            subscription: $subscription,
            amount: 50,
            description: 'Transaction test',
            reference: 'REF-006'
        );

        $this->assertDatabaseHas('wallet_transactions', [
            'tenant_id' => $subscription->tenant_id,
            'customer_id' => $subscription->customer_id,
            'amount' => 50,
            'balance_before' => 100,
            'balance_after' => 150,
            'type' => 'deposit',
            'description' => 'Transaction test',
        ]);
    }

}
