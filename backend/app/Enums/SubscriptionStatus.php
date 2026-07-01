<?php

declare(strict_types=1);

namespace App\Enums;

enum SubscriptionStatus: string
{
    case ACTIVE = 'active';

    case SUSPENDED = 'suspended';

    case EXPIRED = 'expired';
}
