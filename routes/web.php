<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;

Route::view('/', 'welcome');

// User Routes (harus login)
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');

    // Shop
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Orders
    Route::get('/orders', [CheckoutController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [CheckoutController::class, 'show'])->name('orders.show');

    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/upload-proof', [PaymentController::class, 'uploadProof'])->name('payment.uploadProof');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // ✅ Notifications (HARUS DI DALAM GROUP ADMIN)
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [AdminNotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::post('/notifications/{id}/read', [AdminNotificationController::class, 'read'])->name('notifications.read');
});

// Profile
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
