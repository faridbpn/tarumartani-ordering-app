<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderArchiveController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\ReservationController;

// Public Routes (User Pages)
Route::get('/', function () {
    return view('overview');
})->name('home');

Route::get('/admin-only', function () {
    return view('adminOnly');
})->name('admin.only');

Route::get('/gallery', function () {
    return view('overviewGallery');
})->name('gallery');

Route::get('/contactus', function () {
    return view('contactus');
})->name('contactus');

// Registrasi Routes
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');


// Authentication Routes
Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
Route::post('/login', [AdminController::class, 'login'])->name('submit.login');
Route::post('/logout', [AdminController::class, 'logout'])->middleware('auth')->name('logout');

// Admin Routes (Protected)
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'userList'])->name('admin.users');

    // Menu Management
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/{id}', [MenuController::class, 'show']);
    Route::post('/menu', [MenuController::class, 'store']);
    Route::post('/menu/{id}', [MenuController::class, 'update']);
    Route::delete('/menu/{id}', [MenuController::class, 'destroy']);

    // Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{order}/details', [OrderController::class, 'showDetails'])->name('orders.details');

    // Archive routes
    Route::get('/arsip', [OrderArchiveController::class, 'index'])->name('arsip.index');
    Route::post('/orders/{order}/archive', [OrderController::class, 'archive'])->name('orders.archive');
    Route::delete('/orders/{order}/archive', [OrderController::class, 'deleteArchive'])->name('orders.deleteArchive');
    Route::post('/orders/{order}/restore', [OrderArchiveController::class, 'restore'])->name('orders.restore');
    Route::delete('/orders/{order}/destroy', [OrderArchiveController::class, 'destroy'])->name('orders.destroy');
    Route::get('/export-arsip', [OrderArchiveController::class, 'export'])->name('arsip.export');

    // Reservation Management
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('admin.reservation');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('admin.reservations.show');
    Route::post('/reservations/{id}/status', [ReservationController::class, 'updateStatus'])->name('admin.reservations.updateStatus');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('admin.reservations.destroy');

    // Customer Orders
    Route::get('/customers/orders/{id}', [AdminController::class, 'customerOrders'])->name('customers.orders');
});

// User Routes (Protected)
Route::middleware(['auth'])->group(function () {
    // Cart Routes
    Route::get('/menu', [UserController::class, 'index'])->name('menu.public');
    Route::post('/cart/add/{menu}', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{menu}', [OrderController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{menu}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/cart', [OrderController::class, 'showCart'])->name('cart.show');

    // Checkout Routes
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // User Reservation
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');

    // user List bang
    Route::get('/users', [AdminController::class, 'userList'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store'); 
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});

// Login Nomor Meja
Route::get('/nomor-meja/{token}/{nomor_meja}', [MejaController::class, 'nomorMeja'])->name('orders.nomorMeja');
Route::post('/email-nomor-meja', [MejaController::class, 'saveEmailMeja'])->name('save.email.meja');
Route::post('/email-nomor-meja/reset', function () {
    $url = session('url_meja') ?? '/';
    session()->forget(['email', 'name', 'meja_id', 'nomor_meja', 'url_meja']);
    return response()->json(['redirect' => $url]);
})->name('reset.email.session');

Route::middleware(['cekMeja'])->group(function () {
    Route::get('/menu/nomor-meja', [MejaController::class, 'index'])->name('menu.meja.index');
    Route::post('/menu/nomor-meja', [MejaController::class, 'store'])->name('order.meja.store');
});

// Reservation routes
Route::get('/need-to-login', function () {
    return view('needToLogin');
})->name('needToLogin');

Route::get('/user-reservation', function () {
    return view('userReservation');
})->middleware('ensure.user.loggedin')->name('userReservation');