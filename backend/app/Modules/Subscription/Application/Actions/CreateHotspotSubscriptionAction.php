<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Actions;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Network\Domain\Contracts\Services\HotspotServiceInterface;
use App\Modules\Subscription\Domain\Contracts\HotspotSubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;

final readonly class CreateHotspotSubscriptionAction
{
    public function __construct(
        private HotspotSubscriptionRepositoryInterface $repository,
        private HotspotServiceInterface $hotspot,
    ) {}

    public function execute(
        array $data,
    ): HotspotSubscription {

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

        $this->hotspot->createUser(
            $username,
            $password,
            $profile,
        );

        return $this->repository->create([
            ...$data,
            'hotspot_username' => $username,
            'hotspot_password' => $password,
            'mikrotik_profile' => $profile,
        ]);
    }
}
