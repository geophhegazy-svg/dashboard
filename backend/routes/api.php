<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TenantController;

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\HotspotSubscriptionController;

use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PaymentController;

use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ReportController;

use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\DeviceAssignmentController;

use App\Http\Controllers\Api\TicketController;

use App\Http\Controllers\Api\MikrotikController;

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ActivityLogController;

use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\CustomerDashboardController;
use App\Http\Controllers\Api\CustomerSubscriptionController;
use App\Http\Controllers\Api\CustomerInvoiceController;
use App\Http\Controllers\Api\CustomerWalletController;
use App\Http\Controllers\Api\CustomerNotificationController;


use App\Http\Controllers\Api\CustomerTicketController;

use App\Http\Controllers\Api\HotspotController;
use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Api\MikroTikAdvancedController;
use App\Http\Controllers\Api\ScheduledReportController;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);

Route::prefix('customer')->group(function () {

    Route::post('/login', [CustomerAuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource(
        'scheduled-reports',
        ScheduledReportController::class
    );

    Route::patch(
        'scheduled-reports/{scheduledReport}/activate',
        [ScheduledReportController::class, 'activate']
    );

    Route::patch(
        'scheduled-reports/{scheduledReport}/deactivate',
        [ScheduledReportController::class, 'deactivate']
    );

    /*
    |------------------------------------------------------
    | Auth
    |------------------------------------------------------
    */

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post(
        '/tickets/{ticket}/reply',
        [TicketController::class, 'reply']
    );

    Route::get(
        '/tickets/{ticket}/messages',
        [TicketController::class, 'messages']
    );

    /*
    |------------------------------------------------------
    | Dashboard
    |------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/dashboard/stats', [MikrotikController::class, 'dashboardStats']);

    /*
    |------------------------------------------------------
    | Resources
    |------------------------------------------------------
    */

    Route::apiResource('users', UserController::class);
    Route::apiResource('tenants', TenantController::class);

    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('packages', PackageController::class);

    Route::apiResource('subscriptions', SubscriptionController::class);
    Route::apiResource('hotspot-subscriptions', HotspotSubscriptionController::class);

    Route::apiResource('invoices', InvoiceController::class);
    Route::apiResource('payments', PaymentController::class);

    Route::apiResource('devices', DeviceController::class);
    Route::apiResource('inventories', InventoryController::class);
    Route::apiResource('device-assignments', DeviceAssignmentController::class);


    /*
|--------------------------------------------------------------------------
| Support Center
|--------------------------------------------------------------------------
*/

    Route::apiResource('tickets', TicketController::class);

    Route::prefix('tickets')->group(function () {

        /*
    |--------------------------------------------------------------------------
    | Conversation
    |--------------------------------------------------------------------------
    */

        Route::get(
            '/{ticket}/messages',
            [TicketController::class, 'messages']
        );

        Route::post(
            '/{ticket}/reply',
            [TicketController::class, 'reply']
        );

        /*
    |--------------------------------------------------------------------------
    | Assignment
    |--------------------------------------------------------------------------
    */

        Route::post(
            '/{ticket}/assign',
            [TicketController::class, 'assign']
        );

        /*
    |--------------------------------------------------------------------------
    | Status
    |--------------------------------------------------------------------------
    */

        Route::post(
            '/{ticket}/status',
            [TicketController::class, 'changeStatus']
        );

        /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

        Route::get(
            '/dashboard/statistics',
            [TicketController::class, 'dashboard']
        );
    });

    Route::apiResource('notifications', NotificationController::class);

    Route::apiResource('activity-logs', ActivityLogController::class)
        ->only(['index', 'show']);

    /*
    |------------------------------------------------------
    | Subscription Actions
    |------------------------------------------------------
    */

    Route::get(
        '/subscriptions/available-pppoe-users',
        [SubscriptionController::class, 'availablePppoeUsers']
    );

    Route::post(
        '/subscriptions/{subscription}/link-pppoe',
        [SubscriptionController::class, 'linkPppoe']
    );

    Route::post(
        '/subscriptions/{subscription}/activate',
        [SubscriptionController::class, 'activate']
    );

    Route::post(
        '/subscriptions/{subscription}/suspend',
        [SubscriptionController::class, 'suspend']
    );

    Route::post(
        '/subscriptions/{subscription}/renew',
        [SubscriptionController::class, 'renew']
    );

    /*
    |------------------------------------------------------
    | Hotspot Subscription Actions
    |------------------------------------------------------
    */

    Route::post(
        '/hotspot-subscriptions/{hotspotSubscription}/activate',
        [HotspotSubscriptionController::class, 'activate']
    );

    Route::post(
        '/hotspot-subscriptions/{hotspotSubscription}/suspend',
        [HotspotSubscriptionController::class, 'suspend']
    );

    /*
    |------------------------------------------------------
    | Device Assignment
    |------------------------------------------------------
    */

    Route::post(
        '/device-assignments/{device_assignment}/return',
        [DeviceAssignmentController::class, 'returnDevice']
    );

    /*
    |------------------------------------------------------
    | Notifications
    |------------------------------------------------------
    */

    Route::post(
        '/notifications/{notification}/read',
        [NotificationController::class, 'markAsRead']
    );

    Route::post(
        '/notifications/read-all',
        [NotificationController::class, 'markAllAsRead']
    );

    /*
    |------------------------------------------------------
    | Reports
    |------------------------------------------------------
    */

    Route::prefix('reports')->group(function () {

        Route::get('/dashboard', [ReportController::class, 'dashboard']);
        Route::get('/revenue', [ReportController::class, 'revenue']);
        Route::get('/invoices', [ReportController::class, 'invoices']);
        Route::get('/inventory', [ReportController::class, 'inventory']);
        Route::get('/tickets', [ReportController::class, 'tickets']);
    });

    /*
    |------------------------------------------------------
    | MikroTik
    |------------------------------------------------------
    */

    Route::prefix('mikrotik')->group(function () {

        Route::get('/test', [MikrotikController::class, 'test']);

        Route::get('/dashboard-stats', [MikrotikController::class, 'dashboardStats']);

        Route::get('/pppoe-users', [MikrotikController::class, 'pppoeUsers']);
        Route::post('/pppoe-users', [MikrotikController::class, 'createPppoeUser']);

        Route::get('/hotspot-users', [MikrotikController::class, 'hotspotUsers']);
        Route::get('/hotspot-users/active', [MikrotikController::class, 'activeUsers']);

        Route::post('/hotspot-users', [MikrotikController::class, 'createHotspotUser']);

        Route::delete(
            '/hotspot-users/{username}',
            [MikrotikController::class, 'deleteHotspotUser']
        );

        Route::post(
            '/hotspot-users/{username}/activate',
            [MikrotikController::class, 'activateHotspotUser']
        );

        Route::post(
            '/hotspot-users/{username}/suspend',
            [MikrotikController::class, 'suspendHotspotUser']
        );
    });
});

/*
|--------------------------------------------------------------------------
| Customer App Routes
|--------------------------------------------------------------------------
*/

Route::prefix('customer')
    ->middleware('auth:sanctum')
    ->group(function () {

        /*
        |------------------------------------------------------
        | Authentication
        |------------------------------------------------------
        */

        Route::get('/me', [CustomerAuthController::class, 'me']);
        Route::post('/logout', [CustomerAuthController::class, 'logout']);
        Route::put('/profile', [CustomerAuthController::class, 'updateProfile']);
        Route::post('/change-password', [CustomerAuthController::class, 'changePassword']);

        /*
        |------------------------------------------------------
        | Dashboard
        |------------------------------------------------------
        */

        Route::get('/dashboard', [CustomerDashboardController::class, 'index']);

        /*
        |------------------------------------------------------
        | Subscription
        |------------------------------------------------------
        */

        Route::get('/subscription', [
            CustomerSubscriptionController::class,
            'current'
        ]);

        Route::post('/subscription/renew', [
            CustomerSubscriptionController::class,
            'renew'
        ]);

        /*
        |------------------------------------------------------
        | Wallet
        |------------------------------------------------------
        */

        Route::get('/wallet', [
            CustomerWalletController::class,
            'show'
        ]);

        Route::get('/wallet/transactions', [
            CustomerWalletController::class,
            'transactions'
        ]);

        /*
        |------------------------------------------------------
        | Invoices
        |------------------------------------------------------
        */

        Route::get('/invoices', [
            CustomerInvoiceController::class,
            'index'
        ]);

        Route::get('/invoices/{invoice}', [
            CustomerInvoiceController::class,
            'show'
        ]);

        /*
        |------------------------------------------------------
        | Notifications
        |------------------------------------------------------
        */

        Route::get('/notifications', [
            CustomerNotificationController::class,
            'index'
        ]);

        Route::post('/notifications/{id}/read', [
            CustomerNotificationController::class,
            'markAsRead'
        ]);

        Route::post('/notifications/read-all', [
            CustomerNotificationController::class,
            'markAllAsRead'
        ]);

        /*
        |------------------------------------------------------
        | Tickets
        |------------------------------------------------------
        */

        Route::get('/tickets/dashboard', [
            CustomerTicketController::class,
            'dashboard'
        ]);

        Route::get('/tickets', [
            CustomerTicketController::class,
            'index'
        ]);

        Route::post('/tickets', [
            CustomerTicketController::class,
            'store'
        ]);

        Route::get('/tickets/{ticket}', [
            CustomerTicketController::class,
            'show'
        ]);

        Route::get(
            '/tickets/{ticket}/messages',
            [CustomerTicketController::class, 'messages']
        );

        Route::post('/tickets/{ticket}/reply', [
            CustomerTicketController::class,
            'reply'
        ]);

        Route::post('/tickets/{ticket}/close', [
            CustomerTicketController::class,
            'close'
        ]);
    });
// Route::middleware('auth:sanctum')->prefix('network')->group(function () {


Route::middleware('auth:sanctum')->group(function () {

    Route::get(
        '/network/dhcp/leases',
        [MikrotikController::class, 'dhcpLeases']
    );
});
Route::prefix('hotspot')->group(function () {
    Route::get('online', [HotspotController::class, 'onlineUsers']);
    Route::get('stats', [HotspotController::class, 'stats']);
});

Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
Route::apiResource('tasks', TaskController::class);
/*
|--------------------------------------------------------------------------
| MikroTik Advanced Routes
|--------------------------------------------------------------------------
*/

Route::prefix('mikrotik/advanced')->middleware('auth:sanctum')->group(function () {

    // Queues
    Route::get('/queues', [MikroTikAdvancedController::class, 'getQueues']);
    Route::post('/queues', [MikroTikAdvancedController::class, 'createQueue']);
    Route::put('/queues/{name}', [MikroTikAdvancedController::class, 'updateQueue']);
    Route::delete('/queues/{name}', [MikroTikAdvancedController::class, 'deleteQueue']);
    Route::post('/queues/{name}/toggle', [MikroTikAdvancedController::class, 'toggleQueue']);

    // Firewall
    Route::get('/firewall', [MikroTikAdvancedController::class, 'getFirewallRules']);
    Route::post('/firewall', [MikroTikAdvancedController::class, 'createFirewallRule']);
    Route::delete('/firewall/{id}', [MikroTikAdvancedController::class, 'deleteFirewallRule']);

    // NAT
    Route::get('/nat', [MikroTikAdvancedController::class, 'getNATRules']);

    // DHCP
    Route::get('/dhcp', [MikroTikAdvancedController::class, 'getDHCPLeases']);
    Route::post('/dhcp', [MikroTikAdvancedController::class, 'addDHCPLease']);
    Route::delete('/dhcp/{id}', [MikroTikAdvancedController::class, 'deleteDHCPLease']);
});


