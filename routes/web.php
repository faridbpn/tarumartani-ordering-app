<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('submit.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Routes
Route::get('/', [MenuController::class, 'publicIndex'])->name('home');
Route::get('/menu', [MenuController::class, 'publicIndex'])->name('menu.public');

// Cart Routes
Route::post('/cart/add/{menu}', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{menu}', [OrderController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{menu}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.show');

// Checkout Routes
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/success/{order}', [OrderController::class, 'success'])->name('orders.success');

// Admin Routes (Protected)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/admin', [OrderController::class, 'index'])->name('admin.dashboard');
    
    // Menu Management
    Route::get('/admin/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/admin/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::put('/admin/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/admin/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
    
    // Order Management
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::put('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/admin/orders/archive', [OrderController::class, 'archive'])->name('orders.archive');
});
