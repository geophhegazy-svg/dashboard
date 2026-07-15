<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\StateMachine;

use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;

class SubscriptionStateMachine implements StateTransition
{
    private const MAP = [

        SubscriptionStatus::DRAFT->value => [
            SubscriptionStatus::PENDING->value,
            SubscriptionStatus::CANCELLED->value,
        ],

        SubscriptionStatus::PENDING->value => [
            SubscriptionStatus::ACTIVE->value,
            SubscriptionStatus::CANCELLED->value,
        ],

        SubscriptionStatus::ACTIVE->value => [
            SubscriptionStatus::SUSPENDED->value,
            SubscriptionStatus::GRACE->value,
            SubscriptionStatus::EXPIRED->value,
        ],

        SubscriptionStatus::GRACE->value => [
            SubscriptionStatus::ACTIVE->value,
            SubscriptionStatus::EXPIRED->value,
        ],

        SubscriptionStatus::SUSPENDED->value => [
            SubscriptionStatus::ACTIVE->value,
            SubscriptionStatus::TERMINATED->value,
        ],

        SubscriptionStatus::EXPIRED->value => [
            SubscriptionStatus::ACTIVE->value,
            SubscriptionStatus::TERMINATED->value,
        ],

        SubscriptionStatus::CANCELLED->value => [],

        SubscriptionStatus::TERMINATED->value => [],
    ];

    public function canTransition(
        string $from,
        string $to
    ): bool {

        return in_array(
            $to,
            self::MAP[$from] ?? [],
            true
        );
    }
}
