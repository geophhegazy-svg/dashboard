<?php

declare(strict_types=1);

namespace App\Enums;

enum JournalStatus: string
{
    case Draft = 'draft';

    case Posted = 'posted';

    case Cancelled = 'cancelled';
}
