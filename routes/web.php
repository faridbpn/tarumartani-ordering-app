<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// Public Routes (User Pages)
Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/menu', [UserController::class, 'index'])->name('menu.public');

// Cart Routes
Route::post('/cart/add/{menu}', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{menu}', [OrderController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{menu}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.show');

// Authentication Routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('submit.login');
Route::post('/admin/logout', [AdminController::class, 'logout'])->middleware('auth')->name('logout');

// Checkout Routes
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/success/{order}', [OrderController::class, 'success'])->name('orders.success');

// Admin Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Menu Management
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{id}', [MenuController::class, 'show']);
    Route::post('/menu', [MenuController::class, 'store']);
    Route::post('/menu/{id}', [MenuController::class, 'update']);
    Route::delete('/menu/{id}', [MenuController::class, 'destroy']);
    
    // Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/archive', [OrderController::class, 'arsip'])->name('orders.arsip');




});
