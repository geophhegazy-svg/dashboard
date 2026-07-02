<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Dashboard
            'dashboard.view',
            'dashboard.statistics',

            // Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',

            // Customers
            'customers.view',
            'customers.create',
            'customers.update',
            'customers.delete',

            // Packages
            'packages.view',
            'packages.create',
            'packages.update',
            'packages.delete',

            // Subscriptions
            'subscriptions.view',
            'subscriptions.create',
            'subscriptions.update',
            'subscriptions.delete',
            'subscriptions.activate',
            'subscriptions.suspend',
            'subscriptions.renew',
            'subscriptions.restore',
            'subscriptions.expire',
            'subscriptions.link_pppoe',

            // Hotspot
            'hotspot.view',
            'hotspot.create',
            'hotspot.update',
            'hotspot.delete',
            'hotspot.activate',
            'hotspot.suspend',

            // Invoices
            'invoices.view',
            'invoices.create',
            'invoices.update',
            'invoices.delete',

            // Payments
            'payments.view',
            'payments.create',
            'payments.update',
            'payments.delete',

            // Wallet
            'wallet.view',
            'wallet.deposit',
            'wallet.withdraw',
            'wallet.transactions',

            // Notifications
            'notifications.view',
            'notifications.create',
            'notifications.delete',
            'notifications.read',

            // Reports
            'reports.dashboard',
            'reports.revenue',
            'reports.inventory',
            'reports.invoices',
            'reports.tickets',

            // Tickets
            'tickets.view',
            'tickets.create',
            'tickets.update',
            'tickets.delete',
            'tickets.reply',
            'tickets.assign',
            'tickets.change_status',

            // Inventory
            'inventory.view',
            'inventory.create',
            'inventory.update',
            'inventory.delete',

            // Devices
            'devices.view',
            'devices.create',
            'devices.update',
            'devices.delete',

            'device_assignments.create',
            'device_assignments.return',

            // MikroTik
            'mikrotik.view',

            'mikrotik.pppoe.view',
            'mikrotik.pppoe.create',
            'mikrotik.pppoe.update',
            'mikrotik.pppoe.delete',

            'mikrotik.hotspot.view',
            'mikrotik.hotspot.create',
            'mikrotik.hotspot.update',
            'mikrotik.hotspot.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin'
        ]);

        $tenantAdmin = Role::firstOrCreate([
            'name' => 'Tenant Admin'
        ]);

        $manager = Role::firstOrCreate([
            'name' => 'Manager'
        ]);

        $accountant = Role::firstOrCreate([
            'name' => 'Accountant'
        ]);

        $support = Role::firstOrCreate([
            'name' => 'Support'
        ]);

        $technician = Role::firstOrCreate([
            'name' => 'Technician'
        ]);

        $customer = Role::firstOrCreate([
            'name' => 'Customer'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions
        |--------------------------------------------------------------------------
        */

        // Super Admin
        $superAdmin->syncPermissions(Permission::all());

        // Tenant Admin
        $tenantAdmin->syncPermissions(Permission::all());

        // Manager
        $manager->syncPermissions([
            'dashboard.view',
            'dashboard.statistics',

            'customers.view',
            'customers.create',
            'customers.update',

            'packages.view',
            'packages.create',
            'packages.update',

            'subscriptions.view',
            'subscriptions.activate',
            'subscriptions.suspend',
            'subscriptions.renew',

            'reports.dashboard',
            'reports.revenue',
            'reports.inventory',
            'reports.invoices',

            'tickets.view',
            'tickets.reply',

            'devices.view',
            'inventory.view',
        ]);

        // Accountant
        $accountant->syncPermissions([
            'customers.view',
            'subscriptions.view',

            'invoices.view',
            'invoices.create',

            'payments.view',
            'payments.create',

            'wallet.view',
            'wallet.transactions',

            'reports.dashboard',
            'reports.revenue',
            'reports.invoices',
        ]);

        // Support
        $support->syncPermissions([
            'customers.view',
            'subscriptions.view',

            'tickets.view',
            'tickets.reply',
            'tickets.change_status',

            'notifications.view',
            'notifications.read',
        ]);

        // Technician
        $technician->syncPermissions([
            'devices.view',
            'devices.update',

            'inventory.view',

            'mikrotik.view',

            'mikrotik.pppoe.view',
            'mikrotik.pppoe.update',

            'mikrotik.hotspot.view',
            'mikrotik.hotspot.update',

            'subscriptions.activate',
            'subscriptions.suspend',
            'subscriptions.restore',
        ]);

        // Customer
        $customer->syncPermissions([]);
    }
}
