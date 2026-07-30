<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Database;

use App\Core\Workflow\Contracts\TransactionManagerInterface;
use Illuminate\Support\Facades\DB;

final class LaravelTransactionManager implements TransactionManagerInterface
{
    public function transaction(callable $callback): mixed
    {
        return DB::transaction($callback);
    }
}
