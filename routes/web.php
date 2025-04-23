<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\PreventBackHistory; // ✅ Tambahkan ini

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

// Route untuk halaman login (untuk pengguna yang belum login)
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');

// ✅ Admin Routes (Login + Prevent Back History)
Route::middleware(['auth', PreventBackHistory::class])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Menu Management
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::put('/menu/{menu}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menu}', [MenuController::class, 'destroy'])->name('menu.destroy');
    Route::get('/menu-items', function () {
        return view('menuItems');
    })->name('menu.items');

    // Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/archive', [OrderController::class, 'arsip'])->name('orders.arsip');

    // Logout Route
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerate();
        return redirect('/admin/login');
    })->name('logout');
    
});
