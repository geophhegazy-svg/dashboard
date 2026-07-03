<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Contracts\MikrotikServiceInterface;
use App\Services\Network\MikrotikService;

use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Device;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\Ticket;
use App\Models\User;

use App\Policies\ActivityLogPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\DevicePolicy;
use App\Policies\InventoryPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\PackagePolicy;
use App\Policies\PaymentPolicy;
use App\Policies\SubscriptionPolicy;
use App\Policies\TenantPolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            MikrotikServiceInterface::class,
            MikrotikService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, string $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Gate::policy(\App\Models\Customer::class, \App\Policies\CustomerPolicy::class);
        Gate::policy(\App\Models\Subscription::class, \App\Policies\SubscriptionPolicy::class);
        Gate::policy(\App\Models\Invoice::class, \App\Policies\InvoicePolicy::class);
        Gate::policy(\App\Models\Payment::class, \App\Policies\PaymentPolicy::class);
        Gate::policy(\App\Models\Device::class, \App\Policies\DevicePolicy::class);
        Gate::policy(\App\Models\Package::class, \App\Policies\PackagePolicy::class);
        Gate::policy(\App\Models\Inventory::class, \App\Policies\InventoryPolicy::class);
        Gate::policy(\App\Models\Ticket::class, \App\Policies\TicketPolicy::class);
        Gate::policy(\App\Models\User::class, \App\Policies\UserPolicy::class);
        Gate::policy(\App\Models\Tenant::class, \App\Policies\TenantPolicy::class);
        Gate::policy(\App\Models\ActivityLog::class, \App\Policies\ActivityLogPolicy::class);
    }
}
