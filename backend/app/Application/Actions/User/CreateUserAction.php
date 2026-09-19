<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final readonly class CreateUserAction
{
    public function execute(
        string $name,
        string $email,
        string $password,
        ?int $tenantId,
        string $role,
    ): User {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'tenant_id' => $tenantId,
        ]);

        $user->assignRole($role);

        return $user;
    }
}
