<?php

declare(strict_types=1);

namespace App\Modules\Customer\Policies;

use App\Core\Security\Authorization\BasePolicy;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Models\User;

final class CustomerPolicy extends BasePolicy
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
