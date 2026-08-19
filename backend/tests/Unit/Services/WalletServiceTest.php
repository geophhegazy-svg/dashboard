<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Wallet\Application\Actions\DeductWalletAction;
use App\Modules\Wallet\Application\Actions\DepositWalletAction;
use App\Modules\Wallet\Infrastructure\Persistence\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class WalletServiceTest extends TestCase
{
    use RefreshDatabase;

    private function wallet(
        float $balance = 100,
    ): Wallet {
        $customer = Customer::factory()->create();

        return Wallet::create([
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
            'balance' => $balance,
        ]);
    }

    public function test_deposit_increases_wallet_balance_and_creates_transaction(): void
    {
        $wallet = $this->wallet(100);

        app(DepositWalletAction::class)->execute(
            wallet: $wallet,
            amount: 50,
            description: 'Test deposit',
            reference: 'REF-001',
        );

        $wallet->refresh();

        $this->assertEquals(
            150,
            (float) $wallet->balance,
        );

        $this->assertDatabaseHas('wallet_transactions', [
            'tenant_id' => $wallet->tenant_id,
            'customer_id' => $wallet->customer_id,
            'amount' => 50,
            'description' => 'Test deposit',
            'type' => 'deposit',
        ]);
    }

    public function test_deduct_decreases_wallet_balance_and_creates_transaction(): void
    {
        $wallet = $this->wallet(100);

        app(DeductWalletAction::class)->execute(
            wallet: $wallet,
            amount: 40,
            description: 'Test deduct',
            reference: 'REF-002',
        );

        $wallet->refresh();

        $this->assertEquals(
            60,
            (float) $wallet->balance,
        );

        $this->assertDatabaseHas('wallet_transactions', [
            'tenant_id' => $wallet->tenant_id,
            'customer_id' => $wallet->customer_id,
            'amount' => 40,
            'type' => 'deduct',
            'description' => 'Test deduct',
        ]);
    }

    public function test_deduct_fails_when_balance_is_insufficient(): void
    {
        $wallet = $this->wallet(30);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(
            'Insufficient wallet balance.'
        );

        try {
            app(DeductWalletAction::class)->execute(
                wallet: $wallet,
                amount: 50,
                description: 'Test insufficient balance',
                reference: 'REF-003',
            );
        } finally {
            $this->assertDatabaseMissing('wallet_transactions', [
                'tenant_id' => $wallet->tenant_id,
                'customer_id' => $wallet->customer_id,
                'description' => 'Test insufficient balance',
            ]);

            $this->assertEquals(
                30,
                (float) $wallet->refresh()->balance,
            );
        }
    }

    public function test_deduct_fails_with_invalid_amount(): void
    {
        $wallet = $this->wallet(100);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Amount must be greater than zero.'
        );

        app(DeductWalletAction::class)->execute(
            wallet: $wallet,
            amount: 0,
            description: 'Invalid amount test',
            reference: 'REF-004',
        );
    }

    public function test_deduct_fails_with_negative_amount(): void
    {
        $wallet = $this->wallet(100);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Amount must be greater than zero.'
        );

        app(DeductWalletAction::class)->execute(
            wallet: $wallet,
            amount: -10,
            description: 'Negative amount test',
            reference: 'REF-005',
        );
    }

    public function test_deposit_creates_correct_wallet_transaction(): void
    {
        $wallet = $this->wallet(100);

        app(DepositWalletAction::class)->execute(
            wallet: $wallet,
            amount: 50,
            description: 'Transaction test',
            reference: 'REF-006',
        );

        $this->assertDatabaseHas('wallet_transactions', [
            'tenant_id' => $wallet->tenant_id,
            'customer_id' => $wallet->customer_id,
            'amount' => 50,
            'balance_before' => 100,
            'balance_after' => 150,
            'type' => 'deposit',
            'description' => 'Transaction test',
            'reference' => 'REF-006',
        ]);
    }
}
