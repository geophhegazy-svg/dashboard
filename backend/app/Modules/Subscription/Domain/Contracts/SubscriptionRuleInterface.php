<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Domain\Contracts;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

interface SubscriptionRuleInterface
{
    /**
     * هل يسمح بتنفيذ العملية؟
     */
    public function passes(Subscription $subscription): bool;

    /**
     * رسالة الخطأ في حالة الرفض.
     */
    public function message(): string;
}
