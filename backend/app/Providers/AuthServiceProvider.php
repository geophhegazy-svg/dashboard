<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Tenant;
use App\Models\User;
use App\Core\Security\Authorization\Policies\TenantPolicy;
use App\Core\Security\Authorization\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

final class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Tenant::class => TenantPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
