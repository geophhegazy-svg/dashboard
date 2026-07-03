<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use App\Policies\Concerns\AuthorizesByPermission;

class InvoicePolicy
{
    use AuthorizesByPermission;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'invoices.view');
    }

    public function view(User $user, Invoice $invoice): bool
    {
        return $this->can($user, 'invoices.view');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'invoices.create');
    }

    public function update(User $user, Invoice $invoice): bool
    {
        return $this->can($user, 'invoices.update');
    }

    public function delete(User $user, Invoice $invoice): bool
    {
        return $this->can($user, 'invoices.delete');
    }
}
