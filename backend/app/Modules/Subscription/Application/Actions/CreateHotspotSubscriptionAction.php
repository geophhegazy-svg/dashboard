<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Actions;

use App\Core\Tenancy\Contracts\TenantContextInterface;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Subscription\Domain\Contracts\HotspotSubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use Illuminate\Auth\Access\AuthorizationException;

final readonly class CreateHotspotSubscriptionAction
{
    public function __construct(
        private HotspotSubscriptionRepositoryInterface $repository,
        private TenantContextInterface $tenantContext,
    ) {}

    public function execute(array $data): HotspotSubscription
    {
        if (!$this->tenantContext->isGlobal()) {
            $tenantId = $this->tenantContext->tenantId();

            if (
                $tenantId === null
                || (int) $data['tenant_id'] !== $tenantId
            ) {
                throw new AuthorizationException(
                    'Cannot create a hotspot subscription for another tenant.'
                );
            }
        }

        $customer = Customer::findOrFail(
            $data['customer_id']
        );

        $username = 'hs' . $customer->id;
        $password = substr(
            bin2hex(random_bytes(8)),
            0,
            8
        );

        $profile = $data['mikrotik_profile'] ?? 'default';

        return $this->repository->create([
            ...$data,
            'hotspot_username' => $username,
            'hotspot_password' => $password,
            'mikrotik_profile' => $profile,
        ]);
    }
}
