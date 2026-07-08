<?php

declare(strict_types=1);

namespace App\Enums;

enum AccountType: string
{
    case ASSET = 'asset';

    case LIABILITY = 'liability';

    case EQUITY = 'equity';

    case REVENUE = 'revenue';

    case EXPENSE = 'expense';

    public static function values(): array
    {
        return array_column(
            self::cases(),
            'value'
        );
    }
}
