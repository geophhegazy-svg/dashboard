<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\DeviceAssignmentController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\MikrotikController;
use App\Http\Controllers\Api\HotspotSubscriptionController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\CustomerAuthController;
use App\Http\Controllers\Api\CustomerSubscriptionController;
use App\Http\Controllers\Api\CustomerInvoiceController;
use App\Http\Controllers\Api\CustomerWalletController;



Route::get('/mikrotik/test', [MikrotikController::class, 'test']);
Route::apiResource(
    'device-assignments',
    DeviceAssignmentController::class
);
Route::get(
    '/mikrotik/pppoe-users',
    [MikrotikController::class, 'pppoeUsers']
);
Route::post(
    'device-assignments/{device_assignment}/return',
    [DeviceAssignmentController::class, 'returnDevice']
);
Route::post(
    '/mikrotik/pppoe-users',
    [MikrotikController::class, 'createPppoeUser']
);
Route::get(
    '/mikrotik/hotspot-users',
    [MikrotikController::class, 'hotspotUsers']
);

Route::post(
    '/mikrotik/hotspot-users',
    [MikrotikController::class, 'createHotspotUser']
);

Route::delete(
    '/mikrotik/hotspot-users/{username}',
    [MikrotikController::class, 'deleteHotspotUser']
);
Route::get(
    '/mikrotik/hotspot-users/active',
    [MikrotikController::class, 'activeUsers']
);
Route::apiResource(
    'hotspot-subscriptions',
    HotspotSubscriptionController::class
);
Route::post(
    '/hotspot-subscriptions/{hotspotSubscription}/suspend',
    [HotspotSubscriptionController::class, 'suspend']
);

Route::post(
    '/hotspot-subscriptions/{hotspotSubscription}/activate',
    [HotspotSubscriptionController::class, 'activate']
);
Route::apiResource('inventories', InventoryController::class);
Route::apiResource('devices', DeviceController::class);
Route::apiResource('tickets', TicketController::class);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::apiResource('payments', PaymentController::class);
Route::apiResource('invoices', InvoiceController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('packages', PackageController::class);
Route::get(
    '/subscriptions/available-pppoe-users',
    [SubscriptionController::class, 'availablePppoeUsers']
);
Route::post(
    '/subscriptions/{subscription}/link-pppoe',
    [SubscriptionController::class, 'linkPppoe']
);
Route::apiResource(
    'subscriptions',
    SubscriptionController::class
);
Route::post(
    '/subscriptions/{subscription}/suspend',
    [SubscriptionController::class, 'suspend']
);

Route::post(
    '/subscriptions/{subscription}/activate',
    [SubscriptionController::class, 'activate']
);

Route::apiResource('users', UserController::class);
Route::apiResource('tenants', TenantController::class);
Route::prefix('reports')->group(
    function () {

        Route::get(
            '/dashboard',
            [ReportController::class, 'dashboard']
        );

        Route::get(
            '/revenue',
            [ReportController::class, 'revenue']
        );

        Route::get(
            '/invoices',
            [ReportController::class, 'invoices']
        );

        Route::get(
            '/inventory',
            [ReportController::class, 'inventory']
        );

        Route::get(
            '/tickets',
            [ReportController::class, 'tickets']
        );
    });
Route::post(
    '/mikrotik/hotspot-users/{username}/suspend',
    [MikrotikController::class, 'suspendHotspotUser']
);

Route::post(
    '/mikrotik/hotspot-users/{username}/activate',
    [MikrotikController::class, 'activateHotspotUser']
);
Route::get(
    '/mikrotik/dashboard-stats',
    [MikrotikController::class, 'dashboardStats']
);
Route::get(
    '/dashboard/stats',
    [MikrotikController::class, 'dashboardStats']
);
Route::apiResource('notifications', NotificationController::class);

Route::post(
    'notifications/{notification}/read',
    [NotificationController::class, 'markAsRead']
);

Route::post(
    'notifications/read-all',
    [NotificationController::class, 'markAllAsRead']
);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('activity-logs', ActivityLogController::class)
    ->only(['index', 'show']);
Route::prefix('customer')->group(function () {

    Route::post('/login', [CustomerAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/me', [CustomerAuthController::class, 'me']);

        Route::get(
            '/subscription',
            [CustomerSubscriptionController::class, 'current']
        );
    });
});
Route::prefix('customer')->group(function () {

    Route::post('/login', [CustomerAuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/me', [CustomerAuthController::class, 'me']);

        Route::get('/subscription', [CustomerSubscriptionController::class, 'current']);

        Route::get('/wallet', [CustomerWalletController::class, 'show']);

        Route::get('/invoices', [CustomerInvoiceController::class, 'index']);

        Route::get('/invoices/{invoice}', [CustomerInvoiceController::class, 'show']);
    });
});
