<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Package;
use App\Modules\Policies\PackagePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Package::class => PackagePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
