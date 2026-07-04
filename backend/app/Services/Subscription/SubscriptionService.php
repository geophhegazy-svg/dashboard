<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Actions\Subscription\ActivateSubscriptionAction;
use App\Actions\Subscription\ExpireSubscriptionAction;
use App\Actions\Subscription\RenewSubscriptionAction;
use App\Actions\Subscription\RestoreSubscriptionAction;
use App\Actions\Subscription\SuspendSubscriptionAction;
use App\Contracts\MikrotikServiceInterface;
use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Models\Subscription;
use Illuminate\Validation\ValidationException;


class SubscriptionService
{
    public function __construct(
        private readonly SubscriptionRepositoryInterface $subscriptionRepository,
        private readonly MikrotikServiceInterface $mikrotikService,
        private readonly ActivateSubscriptionAction $activateAction,
        private readonly SuspendSubscriptionAction $suspendAction,
        private readonly ExpireSubscriptionAction $expireAction,
        private readonly RenewSubscriptionAction $renewAction,
        private readonly RestoreSubscriptionAction $restoreAction,
    ) {}

    public function activate(
        Subscription $subscription
    ): bool {
        return $this->activateAction->execute($subscription);
    }

    public function suspend(
        Subscription $subscription
    ): bool {
        return $this->suspendAction->execute($subscription);
    }

    public function expire(
        Subscription $subscription
    ): bool {
        return $this->expireAction->execute($subscription);
    }

    public function renew(
        Subscription $subscription,
        int $days = 30
    ): bool {
        return $this->renewAction->execute($subscription, $days);
    }

    public function restore(
        Subscription $subscription
    ): bool {
        return $this->restoreAction->execute($subscription);
    }

    public function availablePppoeUsers(): array
    {
        $users = $this->mikrotikService->getPppoeUsers();

        $linkedUsers = $this->subscriptionRepository->linkedPppoeUsers();

        return array_values(array_filter(
            $users,
            fn($user) =>
            isset($user['name']) &&
                ! in_array($user['name'], $linkedUsers, true)
        ));
    }

    public function linkPppoe(
        Subscription $subscription,
        string $username
    ): Subscription {

        if (! $this->mikrotikService->findPppoe($username)) {
            throw ValidationException::withMessages([
                'username' => [
                    'PPPoE user does not exist on MikroTik.',
                ],
            ]);
        }

        if (
            $this->subscriptionRepository->usernameExists(
                $username,
                $subscription->id
            )
        ) {
            throw ValidationException::withMessages([
                'username' => [
                    'PPPoE user is already linked to another subscription.',
                ],
            ]);
        }

        $this->subscriptionRepository->updatePppoe(
            $subscription,
            $username
        );

        return $subscription->fresh();
    }
}
