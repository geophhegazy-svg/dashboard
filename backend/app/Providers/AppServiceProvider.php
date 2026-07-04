<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Contracts\MikrotikServiceInterface;
use App\Services\Network\MikrotikService;

use App\Contracts\Repositories\BillingRepositoryInterface;
use App\Repositories\Eloquent\BillingRepository;

use App\Contracts\Repositories\SubscriptionRepositoryInterface;
use App\Repositories\Eloquent\SubscriptionRepository;

use App\Services\Customer\CustomerService;
use App\Services\Package\PackageService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // MikroTik
        $this->app->bind(
            MikrotikServiceInterface::class,
            MikrotikService::class
        );

        // Billing Repository
        $this->app->bind(
            BillingRepositoryInterface::class,
            BillingRepository::class
        );

        // Subscription Repository
        $this->app->bind(
            SubscriptionRepositoryInterface::class,
            SubscriptionRepository::class
        );

        $this->app->bind(
            \App\Contracts\Repositories\SubscriptionRepositoryInterface::class,
            \App\Repositories\Eloquent\SubscriptionRepository::class
        );

        $this->app->bind(
            \App\Contracts\Repositories\CustomerRepositoryInterface::class,
            \App\Repositories\Eloquent\CustomerRepository::class
        );

        $this->app->bind(
            \App\Contracts\Repositories\PackageRepositoryInterface::class,
            \App\Repositories\Eloquent\PackageRepository::class
        );

        $this->app->bind(
            \App\Contracts\Repositories\InvoiceRepositoryInterface::class,
            \App\Repositories\Eloquent\InvoiceRepository::class
        );

        $this->app->bind(
            \App\Contracts\Repositories\PaymentRepositoryInterface::class,
            \App\Repositories\Eloquent\PaymentRepository::class
        );

        $this->app->bind(
            \App\Contracts\Repositories\WalletRepositoryInterface::class,
            \App\Repositories\Eloquent\WalletRepository::class
        );

        // Services
        $this->app->singleton(CustomerService::class);

        $this->app->singleton(PackageService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user) {
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
