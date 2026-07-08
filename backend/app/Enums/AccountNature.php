<?php

declare(strict_types=1);

namespace App\Enums;

enum AccountNature: string
{
    case DEBIT = 'debit';

    case CREDIT = 'credit';

    public static function values(): array
    {
        return array_column(
            self::cases(),
            'value'
        );
    }
}
