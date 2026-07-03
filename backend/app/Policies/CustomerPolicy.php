<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy extends BasePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allow($user, 'customers.view');
    }

    public function view(User $user, Customer $customer): bool
    {
        return $this->allow($user, 'customers.view');
    }

    public function create(User $user): bool
    {
        return $this->allow($user, 'customers.create');
    }

    public function update(User $user, Customer $customer): bool
    {
        return $this->allow($user, 'customers.update');
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $this->allow($user, 'customers.delete');
    }
}
