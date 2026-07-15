<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Domain\Enums;

enum AccountingAccount: string
{
    case CASH = 'cash';

    case BANK = 'bank';

    case ACCOUNTS_RECEIVABLE = 'accounts_receivable';

    case CUSTOMER_WALLET = 'customer_wallet';

    case SUBSCRIPTION_REVENUE = 'subscription_revenue';

    case NETWORK_EXPENSE = 'network_expense';

    case OWNER_EQUITY = 'owner_equity';
}
