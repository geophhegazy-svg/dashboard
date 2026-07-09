<?php

declare(strict_types=1);

namespace App\Enums;

enum PostingSource: string
{
    case Invoice = 'invoice';

    case Payment = 'payment';

    case WalletDeposit = 'wallet_deposit';

    case WalletWithdrawal = 'wallet_withdrawal';

    case SubscriptionRenewal = 'subscription_renewal';

    case ManualJournal = 'manual_journal';
}
