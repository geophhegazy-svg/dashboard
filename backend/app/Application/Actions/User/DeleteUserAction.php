<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Models\User;

final readonly class DeleteUserAction
{
    public function execute(User $user): bool
    {
        return $user->delete();
    }
}
