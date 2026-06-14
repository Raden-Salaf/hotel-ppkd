<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\FnbMenuController;
use App\Http\Controllers\Admin\FnbOrderController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UserController;

// ── Halaman Publik ──
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Auth (di-generate otomatis oleh Laravel Breeze) ──
// require __DIR__.'/auth.php';

// Auth belajar manual
Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// log out nya
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Admin Panel ──
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Dashboard — semua role bisa akses
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ── Superadmin + Admin Hotel ──
    Route::middleware('role:superadmin,admin_hotel')->group(function () {

        // Kamar
        Route::resource('rooms', RoomController::class);

        // Booking
        Route::resource('bookings', BookingController::class)->except('edit', 'update');
        Route::patch('bookings/{booking}/status', [BookingController::class, 'updateStatus'])
            ->name('bookings.updateStatus');

        // Ulasan
        Route::get('reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::patch('reviews/{review}/reply', [ReviewController::class, 'reply'])
            ->name('reviews.reply');
        Route::patch('reviews/{review}/toggle', [ReviewController::class, 'togglePublish'])
            ->name('reviews.toggle');
    });

    // ── Superadmin + Admin F&B ──
    Route::middleware('role:superadmin,admin_fnb')->group(function () {

        // Menu F&B
        Route::resource('fnb-menus', FnbMenuController::class);

        // Order F&B
        Route::get('fnb-orders', [FnbOrderController::class, 'index'])
            ->name('fnb-orders.index');
        Route::post('fnb-orders', [FnbOrderController::class, 'store'])
            ->name('fnb-orders.store');
        Route::patch('fnb-orders/{fnbOrder}/status', [FnbOrderController::class, 'updateStatus'])
            ->name('fnb-orders.updateStatus');
    });

    // ── Superadmin Only ──
    Route::middleware('role:superadmin')->group(function () {

        // Users & Role Management
        Route::resource('users', UserController::class)->except('show', 'edit');
    });
});