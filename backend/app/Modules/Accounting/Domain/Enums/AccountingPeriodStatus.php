<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Domain\Enums;

enum AccountingPeriodStatus: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';

    public static function values(): array
    {
        return array_column(
            self::cases(),
            'value',
        );
    }
}
