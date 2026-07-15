<?php

declare(strict_types=1);

namespace App\Services\Accounting;

use App\Enums\AccountNature;
use App\Enums\AccountType;
use App\Models\Account;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

final class ChartOfAccountsService
{
    public function createDefaultAccounts(
        Tenant $tenant
    ): void {

        DB::transaction(function () use ($tenant) {

            $assets = $this->createAccount(
                $tenant,
                '1000',
                'Assets',
                AccountType::ASSET,
                AccountNature::DEBIT,
                1
            );


            $this->createAccount(
                $tenant,
                '1100',
                'Cash',
                AccountType::ASSET,
                AccountNature::DEBIT,
                2,
                $assets->id
            );


            $this->createAccount(
                $tenant,
                '1200',
                'Accounts Receivable',
                AccountType::ASSET,
                AccountNature::DEBIT,
                2,
                $assets->id
            );


            $liabilities = $this->createAccount(
                $tenant,
                '2000',
                'Liabilities',
                AccountType::LIABILITY,
                AccountNature::CREDIT,
                1
            );


            $this->createAccount(
                $tenant,
                '2100',
                'Customer Wallet Liability',
                AccountType::LIABILITY,
                AccountNature::CREDIT,
                2,
                $liabilities->id
            );


            $equity = $this->createAccount(
                $tenant,
                '3000',
                'Equity',
                AccountType::EQUITY,
                AccountNature::CREDIT,
                1
            );


            $this->createAccount(
                $tenant,
                '3100',
                'Owner Equity',
                AccountType::EQUITY,
                AccountNature::CREDIT,
                2,
                $equity->id
            );


            $revenue = $this->createAccount(
                $tenant,
                '4000',
                'Revenue',
                AccountType::REVENUE,
                AccountNature::CREDIT,
                1
            );


            $this->createAccount(
                $tenant,
                '4100',
                'Subscription Revenue',
                AccountType::REVENUE,
                AccountNature::CREDIT,
                2,
                $revenue->id
            );


            $expenses = $this->createAccount(
                $tenant,
                '5000',
                'Expenses',
                AccountType::EXPENSE,
                AccountNature::DEBIT,
                1
            );


            $this->createAccount(
                $tenant,
                '5100',
                'Network Expenses',
                AccountType::EXPENSE,
                AccountNature::DEBIT,
                2,
                $expenses->id
            );
        });
    }


    private function createAccount(
        Tenant $tenant,
        string $code,
        string $name,
        AccountType $type,
        AccountNature $nature,
        int $level,
        ?int $parentId = null
    ): Account {

        return Account::firstOrCreate(
            [
                'tenant_id' => $tenant->id,
                'code'      => $code,
            ],
            [
                'parent_id' => $parentId,
                'name' => $name,
                'type' => $type->value,
                'nature' => $nature->value,
                'level' => $level,
                'is_system' => true,
                'is_active' => true,
            ]
        );
    }
}
