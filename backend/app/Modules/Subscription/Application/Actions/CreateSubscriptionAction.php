<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Actions;

use App\Core\Contracts\ActionInterface;
use App\Modules\Customer\Domain\Contracts\CustomerRepositoryInterface;
use App\Modules\Package\Domain\Contracts\PackageRepositoryInterface;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final readonly class CreateSubscriptionAction implements ActionInterface
{
    public function __construct(
        private CustomerRepositoryInterface $customers,
        private PackageRepositoryInterface $packages,
        private SubscriptionRepositoryInterface $subscriptions,
    ) {
    }

    public function execute(
        mixed ...$arguments
    ): Subscription {
        /** @var array<string, mixed> $attributes */
        $attributes = $arguments[0];

        $customer = $this->customers->find(
            (int) $attributes['customer_id']
        );

        if ($customer === null) {
            throw (new ModelNotFoundException())
                ->setModel(
                    'App\\Modules\\Customer\\Infrastructure\\Persistence\\Models\\Customer',
                    [(int) $attributes['customer_id']]
                );
        }

        $package = $this->packages->find(
            (int) $attributes['package_id']
        );

        if ($package === null) {
            throw (new ModelNotFoundException())
                ->setModel(
                    'App\\Modules\\Package\\Infrastructure\\Persistence\\Models\\Package',
                    [(int) $attributes['package_id']]
                );
        }

        $duration = (int) (
            $attributes['duration_days']
            ?? ($package->duration_days ?? 30)
        );

        return $this->subscriptions->create([
            'tenant_id' => $customer->tenant_id,
            'customer_id' => $customer->id,
            'package_id' => $package->id,

            'start_date' => now(),
            'end_date' => now()->addDays($duration),

            'monthly_price' => $attributes['monthly_price']
                ?? $package->price,

            'status' => SubscriptionStatus::ACTIVE,

            'notes' => $attributes['notes'] ?? null,

            'pppoe_username' =>
                $attributes['pppoe_username'] ?? null,

            'pppoe_password' =>
                $attributes['pppoe_password'] ?? null,

            'mikrotik_profile' =>
                $package->mikrotik_profile,

        ]);
    }
}
