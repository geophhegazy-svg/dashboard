<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\QueueController;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/queues', [QueueController::class, 'index'])->name('queues.index');
Route::get('/queues/create', [QueueController::class, 'create'])->name('queues.create');
Route::post('/queues', [QueueController::class, 'store'])->name('queues.store');
Route::post('/queues/{name}/toggle', [QueueController::class, 'toggle'])->name('queues.toggle');
Route::delete('/queues/{name}', [QueueController::class, 'destroy'])->name('queues.destroy');

// إدارة الـ Firewall
Route::get('/firewall', [App\Http\Controllers\FirewallController::class, 'index'])->name('firewall.index');
Route::get('/firewall/create', [App\Http\Controllers\FirewallController::class, 'create'])->name('firewall.create');
Route::post('/firewall', [App\Http\Controllers\FirewallController::class, 'store'])->name('firewall.store');
Route::delete('/firewall/{id}', [App\Http\Controllers\FirewallController::class, 'destroy'])->name('firewall.destroy');

// إدارة الـ DHCP
Route::get('/dhcp', [App\Http\Controllers\DHCPController::class, 'index'])->name('dhcp.index');
Route::get('/dhcp/create', [App\Http\Controllers\DHCPController::class, 'create'])->name('dhcp.create');
Route::post('/dhcp', [App\Http\Controllers\DHCPController::class, 'store'])->name('dhcp.store');
Route::delete('/dhcp/{id}', [App\Http\Controllers\DHCPController::class, 'destroy'])->name('dhcp.destroy');

// تعديل الـ Queues
Route::get('/queues/{name}/edit', [App\Http\Controllers\QueueController::class, 'edit'])->name('queues.edit');
Route::put('/queues/{name}', [App\Http\Controllers\QueueController::class, 'update'])->name('queues.update');

// تعديل الـ Queues
Route::get('/queues/{name}/edit', [App\Http\Controllers\QueueController::class, 'edit'])->name('queues.edit');
Route::put('/queues/{name}', [App\Http\Controllers\QueueController::class, 'update'])->name('queues.update');

// تعديل الـ Firewall
Route::get('/firewall/{id}/edit', [App\Http\Controllers\FirewallController::class, 'edit'])->name('firewall.edit');
Route::put('/firewall/{id}', [App\Http\Controllers\FirewallController::class, 'update'])->name('firewall.update');

// تعديل الـ DHCP
Route::get('/dhcp/{id}/edit', [App\Http\Controllers\DHCPController::class, 'edit'])->name('dhcp.edit');
Route::put('/dhcp/{id}', [App\Http\Controllers\DHCPController::class, 'update'])->name('dhcp.update');
