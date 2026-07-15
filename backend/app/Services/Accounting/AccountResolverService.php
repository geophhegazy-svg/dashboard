<?php

declare(strict_types=1);

namespace App\Services\Accounting;

use App\Models\Account;
use RuntimeException;

final class AccountResolverService
{
    public function assets(int $tenantId): Account
    {
        return $this->byCode($tenantId, '1000');
    }

    public function cash(int $tenantId): Account
    {
        return $this->byCode($tenantId, '1100');
    }

    public function accountsReceivable(int $tenantId): Account
    {
        return $this->byCode($tenantId, '1200');
    }

    public function liabilities(int $tenantId): Account
    {
        return $this->byCode($tenantId, '2000');
    }

    public function customerWalletLiability(int $tenantId): Account
    {
        return $this->byCode($tenantId, '2100');
    }

    public function equity(int $tenantId): Account
    {
        return $this->byCode($tenantId, '3000');
    }

    public function ownerEquity(int $tenantId): Account
    {
        return $this->byCode($tenantId, '3100');
    }

    public function revenue(int $tenantId): Account
    {
        return $this->byCode($tenantId, '4000');
    }

    public function subscriptionRevenue(int $tenantId): Account
    {
        return $this->byCode($tenantId, '4100');
    }

    public function expenses(int $tenantId): Account
    {
        return $this->byCode($tenantId, '5000');
    }

    public function networkExpenses(int $tenantId): Account
    {
        return $this->byCode($tenantId, '5100');
    }

    private function byCode(
        int $tenantId,
        string $code
    ): Account {

        $account = Account::query()
            ->where('tenant_id', $tenantId)
            ->where('code', $code)
            ->first();

        if ($account !== null) {
            return $account;
        }

        throw new RuntimeException(
            "Account {$code} was not found for tenant {$tenantId}."
        );
    }
}
