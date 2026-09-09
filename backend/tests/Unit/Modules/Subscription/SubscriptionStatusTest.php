<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use PHPUnit\Framework\TestCase;

final class SubscriptionStatusTest extends TestCase
{
    public function test_allowed_transition_matrix(): void
    {
        $expected = [
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
                SubscriptionStatus::CANCELLED->value,
            ],
            SubscriptionStatus::GRACE->value => [
                SubscriptionStatus::ACTIVE->value,
                SubscriptionStatus::EXPIRED->value,
                SubscriptionStatus::CANCELLED->value,
            ],
            SubscriptionStatus::SUSPENDED->value => [
                SubscriptionStatus::ACTIVE->value,
                SubscriptionStatus::CANCELLED->value,
            ],
            SubscriptionStatus::EXPIRED->value => [
                SubscriptionStatus::ACTIVE->value,
                SubscriptionStatus::TERMINATED->value,
            ],
            SubscriptionStatus::CANCELLED->value => [
                SubscriptionStatus::TERMINATED->value,
            ],
            SubscriptionStatus::TERMINATED->value => [],
        ];

        foreach (SubscriptionStatus::cases() as $status) {
            $actual = array_map(
                static fn (SubscriptionStatus $target): string => $target->value,
                $status->allowedTransitions(),
            );

            self::assertSame(
                $expected[$status->value],
                $actual,
                "Unexpected transition map for {$status->value}",
            );

            foreach (SubscriptionStatus::cases() as $target) {
                self::assertSame(
                    in_array($target->value, $expected[$status->value], true),
                    $status->canTransitionTo($target),
                    "{$status->value} -> {$target->value}",
                );
            }
        }
    }

    public function test_business_capabilities(): void
    {
        $expected = [
            'canActivate' => [
                SubscriptionStatus::PENDING,
                SubscriptionStatus::SUSPENDED,
                SubscriptionStatus::EXPIRED,
            ],
            'canSuspend' => [
                SubscriptionStatus::ACTIVE,
            ],
            'canRenew' => [
                SubscriptionStatus::ACTIVE,
                SubscriptionStatus::GRACE,
                SubscriptionStatus::EXPIRED,
            ],
            'canExpire' => [
                SubscriptionStatus::ACTIVE,
                SubscriptionStatus::GRACE,
            ],
            'canRestore' => [
                SubscriptionStatus::SUSPENDED,
                SubscriptionStatus::EXPIRED,
            ],
            'canCancel' => [
                SubscriptionStatus::DRAFT,
                SubscriptionStatus::PENDING,
                SubscriptionStatus::ACTIVE,
                SubscriptionStatus::GRACE,
                SubscriptionStatus::SUSPENDED,
            ],
            'canTerminate' => [
                SubscriptionStatus::EXPIRED,
                SubscriptionStatus::CANCELLED,
            ],
        ];

        foreach ($expected as $method => $allowedStatuses) {
            foreach (SubscriptionStatus::cases() as $status) {
                $expectedResult = in_array(
                    $status,
                    $allowedStatuses,
                    true,
                );

                self::assertSame(
                    $expectedResult,
                    $status->{$method}(),
                    "{$method}() for {$status->value}",
                );
            }
        }
    }
}
