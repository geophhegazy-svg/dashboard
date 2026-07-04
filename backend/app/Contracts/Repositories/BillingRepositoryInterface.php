<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface BillingRepositoryInterface
{
    /**
     * الاشتراكات المستحقة لإصدار فاتورة.
     */
    public function subscriptionsDueForBilling(): Collection;

    /**
     * الاشتراكات التى انتهت فترة السماح الخاصة بها.
     */
    public function subscriptionsDueForSuspension(): Collection;

    /**
     * الاشتراكات التى يجب تحويلها إلى Expired.
     */
    public function subscriptionsDueForExpiration(): Collection;
}
