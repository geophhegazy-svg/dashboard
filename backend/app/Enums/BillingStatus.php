<?php

declare(strict_types=1);

namespace App\Enums;

enum BillingStatus: string
{
    case ACTIVE = 'active';

    case DUE = 'due';

    case GRACE = 'grace';

    case SUSPENDED = 'suspended';

    case EXPIRED = 'expired';
}
