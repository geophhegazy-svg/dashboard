<?php

namespace App\Modules\Accounting\Infrastructure\Persistence\Models;

class Account extends \App\Models\Account
{
    protected static function newFactory()
    {
        return \Database\Factories\AccountFactory::new();
    }
}
