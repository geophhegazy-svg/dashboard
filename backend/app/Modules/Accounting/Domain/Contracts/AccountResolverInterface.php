<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Domain\Contracts;

use App\Models\Account;
use App\Models\Tenant;
use App\Modules\Accounting\Domain\Enums\AccountingAccount;

interface AccountResolverInterface
{
    public function resolve(
        Tenant $tenant,
        AccountingAccount $account
    ): Account;
}
