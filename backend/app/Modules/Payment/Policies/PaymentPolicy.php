<?php

namespace App\Modules\Payment\Policies;

use App\Modules\Payment\Infrastructure\Persistence\Models\Payment;
use App\Models\User;
use App\Core\Security\Authorization\Concerns\AuthorizesByPermission;

class PaymentPolicy
{
    use AuthorizesByPermission;

    public function viewAny(User $user): bool
    {
        return $this->can($user, 'payments.view');
    }

    public function view(User $user, Payment $payment): bool
    {
        return $this->can($user, 'payments.view');
    }

    public function create(User $user): bool
    {
        return $this->can($user, 'payments.create');
    }

    public function update(User $user, Payment $payment): bool
    {
        return $this->can($user, 'payments.update');
    }

    public function delete(User $user, Payment $payment): bool
    {
        return $this->can($user, 'payments.delete');
    }
}
