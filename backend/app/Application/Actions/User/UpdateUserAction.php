<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final readonly class UpdateUserAction
{
    public function execute(
        User $user,
        array $data,
    ): User {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return $user->refresh();
    }
}
