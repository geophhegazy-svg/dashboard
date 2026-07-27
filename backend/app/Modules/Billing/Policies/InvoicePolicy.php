<?php

declare(strict_types=1);

namespace App\Modules\Billing\Policies;

use App\Core\Security\Authorization\BasePolicy;
use App\Models\Invoice;
use App\Models\User;

final class InvoicePolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allow($user, 'invoices.view');
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $this->allow($user, 'invoices.view');
    }

    public function create(User $user): bool
    {
        return $this->allow($user, 'invoices.create');
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $this->allow($user, 'invoices.update');
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        return $this->allow($user, 'invoices.delete');
    }
}
