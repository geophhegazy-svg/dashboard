<?php

declare(strict_types=1);

namespace App\Enums;

enum FinancialTransactionType: string
{
    case PAYMENT = 'payment';

    case REFUND = 'refund';

    case WALLET_DEPOSIT = 'wallet_deposit';

    case WALLET_WITHDRAW = 'wallet_withdraw';

    case ADJUSTMENT = 'adjustment';

    /*
    |--------------------------------------------------------------------------
    | Direction Helpers
    |--------------------------------------------------------------------------
    */

    public function isCredit(): bool
    {
        return match ($this) {
            self::PAYMENT,
            self::WALLET_DEPOSIT => true,

            self::REFUND,
            self::WALLET_WITHDRAW,
            self::ADJUSTMENT => false,
        };
    }

    public function isDebit(): bool
    {
        return ! $this->isCredit();
    }

    /*
    |--------------------------------------------------------------------------
    | Labels
    |--------------------------------------------------------------------------
    */

    public function label(): string
    {
        return match ($this) {
            self::PAYMENT => 'Payment',

            self::REFUND => 'Refund',

            self::WALLET_DEPOSIT => 'Wallet Deposit',

            self::WALLET_WITHDRAW => 'Wallet Withdrawal',

            self::ADJUSTMENT => 'Adjustment',
        };
    }
}
