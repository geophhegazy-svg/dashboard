<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Network\QueueController;

Route::view('/', 'welcome');

Route::middleware('auth')->group(function () {
    Route::get('/queues', [QueueController::class, 'index'])
        ->name('queues.index');
    Route::get('/queues/create', [QueueController::class, 'create'])
        ->name('queues.create');
    Route::post('/queues', [QueueController::class, 'store'])
        ->name('queues.store');
    Route::post('/queues/{name}/toggle', [QueueController::class, 'toggle'])
        ->name('queues.toggle');
    Route::delete('/queues/{name}', [QueueController::class, 'destroy'])
        ->name('queues.destroy');
    Route::get('/queues/{name}/edit', [QueueController::class, 'edit'])
        ->name('queues.edit');
    Route::put('/queues/{name}', [QueueController::class, 'update'])
        ->name('queues.update');

    // Firewall
    Route::get(
        '/firewall',
        [App\Http\Controllers\Api\Network\FirewallController::class, 'index']
    )->name('firewall.index');

    Route::get(
        '/firewall/create',
        [App\Http\Controllers\Api\Network\FirewallController::class, 'create']
    )->name('firewall.create');

    Route::post(
        '/firewall',
        [App\Http\Controllers\Api\Network\FirewallController::class, 'store']
    )->name('firewall.store');

    Route::delete(
        '/firewall/{id}',
        [App\Http\Controllers\Api\Network\FirewallController::class, 'destroy']
    )->name('firewall.destroy');

    Route::get(
        '/firewall/{id}/edit',
        [App\Http\Controllers\Api\Network\FirewallController::class, 'edit']
    )->name('firewall.edit');

    Route::put(
        '/firewall/{id}',
        [App\Http\Controllers\Api\Network\FirewallController::class, 'update']
    )->name('firewall.update');

    // DHCP
    Route::get(
        '/dhcp',
        [App\Http\Controllers\Api\Network\DHCPController::class, 'index']
    )->name('dhcp.index');

    Route::get(
        '/dhcp/create',
        [App\Http\Controllers\Api\Network\DHCPController::class, 'create']
    )->name('dhcp.create');

    Route::post(
        '/dhcp',
        [App\Http\Controllers\Api\Network\DHCPController::class, 'store']
    )->name('dhcp.store');

    Route::get(
        '/dhcp/{id}/edit',
        [App\Http\Controllers\Api\Network\DHCPController::class, 'edit']
    )->name('dhcp.edit');

    Route::put(
        '/dhcp/{id}',
        [App\Http\Controllers\Api\Network\DHCPController::class, 'update']
    )->name('dhcp.update');

    Route::delete(
        '/dhcp/{id}',
        [App\Http\Controllers\Api\Network\DHCPController::class, 'destroy']
    )->name('dhcp.destroy');
});
/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::prefix('customer')->name('customer.')->group(function () {

    // Auth
    Route::get('/login', [App\Http\Controllers\CustomerAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\CustomerAuthController::class, 'login'])->name('login.post');

    Route::middleware('auth:customer')->group(function () {
        Route::post('/logout', [App\Http\Controllers\CustomerAuthController::class, 'logout'])->name('logout');

        // Invoices
        Route::get('/invoices', [App\Http\Controllers\CustomerInvoiceController::class, 'index'])->name('invoices');
        Route::get('/invoices/{id}', [App\Http\Controllers\CustomerInvoiceController::class, 'show'])->name('invoice.show');

        // Tickets
        Route::get('/tickets', [App\Http\Controllers\CustomerTicketController::class, 'index'])->name('tickets');
        Route::get('/tickets/create', [App\Http\Controllers\CustomerTicketController::class, 'create'])->name('ticket.create');
        Route::post('/tickets', [App\Http\Controllers\CustomerTicketController::class, 'store'])->name('ticket.store');
        Route::get('/tickets/{id}', [App\Http\Controllers\CustomerTicketController::class, 'show'])->name('ticket.show');
        Route::post('/tickets/{id}/reply', [App\Http\Controllers\CustomerTicketController::class, 'reply'])->name('ticket.reply');
        Route::post('/tickets/{id}/close', [App\Http\Controllers\CustomerTicketController::class, 'close'])->name('ticket.close');

        // Profile
        Route::get('/profile', [App\Http\Controllers\CustomerProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [App\Http\Controllers\CustomerProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/change-password', [App\Http\Controllers\CustomerProfileController::class, 'changePassword'])->name('profile.change-password');
    });
});
