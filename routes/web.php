<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;

// Trang chủ - Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Routes cho phòng trọ
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

// Routes cho khách thuê
Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
Route::get('/tenants/{tenant}', [TenantController::class, 'show'])->name('tenants.show');
Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
Route::delete('/tenants/{tenant}', [TenantController::class, 'destroy'])->name('tenants.destroy');

// Routes cho hợp đồng
Route::get('/contracts', [ContractController::class, 'index'])->name('contracts.index');
Route::get('/contracts/create', [ContractController::class, 'create'])->name('contracts.create');
Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
Route::get('/contracts/{contract}/edit', [ContractController::class, 'edit'])->name('contracts.edit');
Route::put('/contracts/{contract}', [ContractController::class, 'update'])->name('contracts.update');
Route::delete('/contracts/{contract}', [ContractController::class, 'destroy'])->name('contracts.destroy');

// Routes cho thanh toán
Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');