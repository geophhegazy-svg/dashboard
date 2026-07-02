<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Default Tenant
        |--------------------------------------------------------------------------
        */

        $tenant = Tenant::updateOrCreate(
            [
                'domain' => 'default',
            ],
            [
                'name' => 'Default ISP',
                'email' => 'admin@example.com',
                'phone' => '01000000000',
                'address' => 'Egypt',
                'status' => 'active',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Super Admin User
        |--------------------------------------------------------------------------
        */

        $user = User::updateOrCreate(
            [
                'email' => 'admin@example.com',
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Assign Role
        |--------------------------------------------------------------------------
        */

        $user->assignRole('Super Admin');
    }
}
